<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct(private CartRepositoryInterface $cartRepository)
    {
    }

    public function store(Request $request): void
    {
        $this->cartRepository->storeItem($request->item);

        Session::flash(
            'flash',
            '<b>' . $request->item['maker']['name'] . ' ' . $request->item['model']['name'] . '</b> добавлен в корзину.'
        );
    }

    public function delete($id): void
    {
        $this->cartRepository->deleteItem($id);

        $transport = Transport::query()->find($id);

        Session::flash(
            'flash',
            '<b>' . $transport->maker->name . ' ' . $transport->model->name . '</b> удален из корзины.'
        );
    }
}
