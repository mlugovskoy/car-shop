<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->getAllOrdersForCurrentUser();

        $total = number_format($orders->sum('price'), 0, '.', ' ') . ' ₽';

        return Inertia::render('Order/Index', ['items' => OrderResource::collection($orders), 'total' => $total]);
    }

    public function create()
    {
        return Inertia::render('Order/Create');
    }
}
