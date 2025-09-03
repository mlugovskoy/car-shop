<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\OrderRequest;

interface OrderRepositoryInterface
{
    public function getAllOrdersForCurrentUser();

    public function storeOrder(OrderRequest $request);
}
