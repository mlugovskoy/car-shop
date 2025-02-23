<?php

namespace App\Repositories;

use App\Helpers\ClearCache;
use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CartRepository implements CartRepositoryInterface
{
    protected int $cacheTime = 10;

    public function __construct(protected CartItem $model, protected ClearCache $cacheHelper)
    {
    }

    public function getCartItems()
    {
        if (!auth()->check()) {
            return collect();
        }

        $cacheKey = 'cart_items';

        return Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return $this->model->query()
                ->with([
                    'transport.maker',
                    'transport.model',
                    'transport.images',
                    'transport'
                ])
                ->where('user_id', auth()->id())
                ->get();
        });
    }

    public function storeItem($transport)
    {
        if (auth()->guest()) {
            abort(401);
        }

        /** @var CartItem $newItem */
        $newItem = $this->model->query()->create(
            [
                'code' => Str::random(),
                'user_id' => auth()->id(),
                'transport_id' => $transport['id'],
            ]
        );

        $this->cacheHelper->removeSectionCache(
            ['cart_items', 'all_cart_items_for_current_user_' . auth()->id()]
        );

        return $newItem;
    }

    public function deleteItem($id)
    {
        $this->model->query()->where('user_id', auth()->id())->where(
            'transport_id',
            $id
        )->delete();

        $this->cacheHelper->removeSectionCache(
            ['cart_items', 'all_cart_items_for_current_user_' . auth()->id()]
        );
    }

    public function total()
    {
        $items = $this->model->query()
            ->with([
                'transport' => function ($query) {
                    $query->select(['id', 'price']);
                }
            ])
            ->where('user_id', auth()->id())
            ->get(['transport_id']);


        return $items->sum(function ($item) {
            return $item->transport->price;
        });
    }

    public function getCartItemsForCurrentUser()
    {
        $currentUserId = auth()->id();

        $cacheKey = 'all_cart_items_for_current_user_' . $currentUserId;

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () use ($currentUserId) {
            return $this->model
                ->query()
                ->with(['transport', 'transport.maker', 'transport.model', 'transport.images'])
                ->where('user_id', $currentUserId)
                ->get(['id', 'code', 'transport_id', 'created_at']);
        });
    }

    public function clearCart(): void
    {
        $currentUserId = auth()->id();

        $allCartItemsForCurrentUser = $this->model
            ->query()
            ->where(['user_id' => $currentUserId])
            ->pluck('id');

        $this->model->destroy($allCartItemsForCurrentUser);

        $this->cacheHelper->removeSectionCache(['all_cart_items_for_current_user_' . $currentUserId, 'cart_items']);
    }
}
