<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct(private CartRepositoryInterface $cartRepository)
    {
    }

    public function store(Request $request)
    {
        $this->cartRepository->storeItem($request->item);

        Session::flash(
            'flash',
            'Ваше объявление #' . $request->item['id'] . ' создано ' . $request->item['published_at'] . '! <br> Ожидайте подтверждения администратора.'
        );
    }

    public function delete($id)
    {
        $this->cartRepository->deleteItem($id);

        Session::flash(
            'flash',
            'Товар #' . $id . ' удален из корзины.'
        );
    }
}
