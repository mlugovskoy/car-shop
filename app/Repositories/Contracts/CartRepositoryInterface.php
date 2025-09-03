<?php

namespace App\Repositories\Contracts;

interface CartRepositoryInterface
{
    public function getCartItems();

    public function storeItem($transport);

    public function deleteItem($id);

    public function total();

    public function clearCart();
}
