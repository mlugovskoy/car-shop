<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;

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
    }

    public function delete($id)
    {
        $this->cartRepository->deleteItem($id);
    }
}
