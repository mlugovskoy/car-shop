<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Collection;

class CurrencyRepository implements CurrencyRepositoryInterface
{

    public function __construct(private Currency $model)
    {
    }

    public function getAllCurrency(): Collection
    {
        return $this->model
            ->query()
            ->pluck('code')
            ->map(fn($code) => ['value' => $code]);
    }
}
