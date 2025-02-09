<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\CartItemResource;
use App\Repositories\CartRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    protected OrderRepository $orderRepository;
    protected CartRepository $cartRepository;

    public function __construct(OrderRepository $orderRepository, CartRepository $cartRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->getAllOrdersForCurrentUser();

        $total = number_format($orders->sum('price'), 0, '.', ' ') . ' ₽';

        return Inertia::render('Order/Index', ['items' => OrderResource::collection($orders), 'total' => $total]);
    }

    public function create()
    {
        $cartItems = $this->cartRepository->getCartItemsForCurrentUser();

        $totalPrice = number_format($cartItems->pluck('transport.price')->sum(), 0, '.', ' ') . ' ₽';

        $total = $cartItems->count();

        return Inertia::render(
            'Order/Create',
            ['items' => CartItemResource::collection($cartItems), 'total_price' => $totalPrice, 'total' => $total]
        );
    }
}
