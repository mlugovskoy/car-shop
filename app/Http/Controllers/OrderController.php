<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\CartItemResource;
use App\Jobs\SendMailJob;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Repositories\CartRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
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
        $cartItems = $this->cartRepository->getCartItems();

        $totalPrice = number_format($cartItems->pluck('transport.price')->sum(), 0, '.', ' ') . ' ₽';

        $total = $cartItems->count();

        return Inertia::render(
            'Order/Create',
            ['items' => CartItemResource::collection($cartItems), 'total_price' => $totalPrice, 'total' => $total]
        );
    }

    public function store(OrderRequest $request)
    {
        $order = $this->orderRepository->storeOrder($request);
        $this->cartRepository->clearCart();

        SendMailJob::dispatch(['user' => $request->user(), 'order' => $order]);

        Session::flash(
            'flash',
            "Заказ оформлен! Скоро с вами свяжется администратор."
        );

        return Redirect::route('home');
    }
}
