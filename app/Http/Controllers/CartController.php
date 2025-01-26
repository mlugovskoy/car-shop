<?php

namespace App\Http\Controllers;

use App\Http\Resources\Color;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(Request $request)
    {
        $this->cartService->addItem($request->item);
        $this->cartService->total();
    }

    public function delete($id)
    {
        $this->cartService->deleteItem($id);
        $this->cartService->total();
    }
}
