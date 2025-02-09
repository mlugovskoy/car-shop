<?php

namespace App\Repositories;

use App\Helpers\ClearCache;
use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CartRepository implements CartRepositoryInterface
{
    protected int $cacheTime = 10;

    public function __construct(protected CartItem $model, protected ClearCache $cacheHelper)
    {
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
}
