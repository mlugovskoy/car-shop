<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    protected CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
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
