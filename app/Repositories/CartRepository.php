<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Services\Contracts\CacheInterface;
use Illuminate\Support\Str;

class CartRepository implements CartRepositoryInterface
{
    public function __construct(private CartItem $model, private CacheInterface $cache)
    {
    }

    public function getCartItems()
    {
        if (!auth()->check()) {
            return collect();
        }

        $item = $this->model
            ->query()
            ->with([
                'transport.maker',
                'transport.model',
                'transport.images',
                'transport'
            ])
            ->where('user_id', auth()->id())
            ->get();

        return $this->cache->save($item, $this->model::CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function storeItem($transport)
    {
        if (auth()->guest()) {
            abort(401);
        }

        $newItem = $this->model
            ->query()
            ->create([
                'code' => Str::random(),
                'user_id' => auth()->id(),
                'transport_id' => $transport['id'],
            ]);

        $this->cache->deleteItem($this->model::CACHE_KEY);

        return $newItem;
    }

    public function deleteItem($id): void
    {
        $this->model
            ->query()
            ->where('user_id', auth()->id())
            ->where('transport_id', $id)
            ->delete();

        $this->cache->deleteItem($this->model::CACHE_KEY);
    }

    public function total()
    {
        $items = $this->model
            ->query()
            ->with(['transport' => fn($query) => $query->select(['id', 'price'])])
            ->where('user_id', auth()->id())
            ->get(['transport_id']);


        return $items->sum(fn($item) => $item->transport->price);
    }

    public function clearCart(): void
    {
        $currentUserId = auth()->id();

        $allCartItemsForCurrentUser = $this->model
            ->query()
            ->where(['user_id' => $currentUserId])
            ->pluck('id');

        $this->model->destroy($allCartItemsForCurrentUser);

        $this->cache->deleteItem($this->model::CACHE_KEY);
    }
}
