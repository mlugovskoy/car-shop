<?php

namespace App\Repositories;

use App\Helpers\ClearCache;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderTransport;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
                ->with(['user', 'transport', 'orderTransports'])
                ->where('user_id', $currentUserId)
                ->get(['id', 'code', 'price', 'created_at']);
        });
    }

    public function storeOrder(OrderRequest $request): void
    {
        $newOrder = $this->model::query()
            ->create(
                [
                    'code' => Str::random(),
                    'first_name' => $request->firstName ?? null,
                    'last_name' => $request->lastName ?? null,
                    'city' => $request->city,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'price' => $request->price,
                    'user_id' => auth()->id(),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );

        collect($request->transports_id)->each(function ($id) use ($newOrder) {
            OrderTransport::query()
                ->create([
                    'order_id' => $newOrder->id,
                    'transport_id' => $id,
                ]);
        });

        $currentUserId = auth()->id();

        $this->cacheHelper->removeSectionCache(['all_cart_items_for_current_user_' . $currentUserId, 'cart_items']);
    }
}
