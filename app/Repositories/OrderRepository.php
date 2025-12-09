<?php

namespace App\Repositories;

use App\Http\Requests\OrderRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderTransport;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\CacheInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(private Order $model, private CacheInterface $cache)
    {
    }

    public function getAllOrdersForCurrentUser()
    {
        $currentUserId = auth()->id();

        $item = $this->model
            ->query()
            ->with(['user', 'transport', 'orderTransports'])
            ->where('user_id', $currentUserId)
            ->get(['id', 'code', 'price', 'created_at']);

        return $this->cache->save($item, $this->model::CURRENT_CACHE_KEY . "_$currentUserId", $this->model::CACHE_TIME);
    }

    public function storeOrder(OrderRequest $request): Model|Order
    {
        $newOrder = $this->model
            ->query()
            ->create([
                'code' => Str::random(),
                'first_name' => $request->firstName ?? null,
                'last_name' => $request->lastName ?? null,
                'city' => $request->city,
                'phone' => $request->phone,
                'email' => $request->email,
                'price' => $request->price,
                'user_id' => auth()->id(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        collect($request->transports_id)
            ->each(fn($id) => OrderTransport::query()
                ->create([
                    'order_id' => $newOrder->id,
                    'transport_id' => $id,
                ]));

        $currentUserId = auth()->id();

        $this->cache->deleteItems([CartItem::CACHE_KEY, $this->model::CURRENT_CACHE_KEY . "_$currentUserId"]);

        return $newOrder;
    }
}
