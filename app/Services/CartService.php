<?php

namespace App\Services;

use App\Helpers\ClearCache;
use App\Models\CartItem;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CartService
{
    /**
     * @var Auth
     */
    protected Auth $auth;

    /**
     * @var CartItem
     */
    protected CartItem $model;

    public function __construct(Auth $auth, CartItem $model, protected ClearCache $cacheHelper)
    {
        $this->auth = $auth;
        $this->model = $model;
    }

    public function getCartItems()
    {
        if (!$this->auth->check()) {
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
                ->where('user_id', $this->auth->user()->getAuthIdentifier())
                ->get();
        });
    }

    public function total()
    {
        $items = $this->model->query()
            ->with([
                'transport' => function ($query) {
                    $query->select(['id', 'price']);
                }
            ])
            ->where('user_id', $this->auth->user()->getAuthIdentifier())
            ->get(['transport_id']);


        return $items->sum(function ($item) {
            return $item->transport->price;
        });
    }

    public function addItem($transport)
    {
        if ($this->auth->guest()) {
            abort(401);
        }

        /** @var CartItem $newItem */
        $newItem = $this->model->query()->create(
            [
                'code' => Str::random(),
                'user_id' => $this->auth->user()->getAuthIdentifier(),
                'transport_id' => $transport['id'],
            ]
        );

        $this->cacheHelper->removeSectionCache(
            ['cart_items', 'all_cart_items_for_current_user_' . $this->auth->user()->getAuthIdentifier()]
        );

        return $newItem;
    }

    public function deleteItem($id)
    {
        $this->model->query()->where('user_id', $this->auth->user()->getAuthIdentifier())->where(
            'transport_id',
            $id
        )->delete();

        $this->cacheHelper->removeSectionCache(
            ['cart_items', 'all_cart_items_for_current_user_' . $this->auth->user()->getAuthIdentifier()]
        );
    }
}
