<?php

namespace App\Repositories;

use App\Helpers\ClearCache;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class OrderRepository implements OrderRepositoryInterface
{
    protected int $cacheTime = 10;

    public function __construct(protected Order $model, protected ClearCache $cacheHelper)
    {
    }

    public function getAllOrdersForCurrentUser()
    {
        $currentUserId = auth()->id();

        $cacheKey = 'all_orders_for_current_user_' . $currentUserId;

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () use ($currentUserId) {
            return $this->model
                ->query()
                ->with(['user', 'transport'])
                ->where('user_id', $currentUserId)
                ->get(['id', 'code', 'quantity', 'price', 'created_at']);
        });
    }
}
