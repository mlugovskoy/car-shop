<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CurrencyRepository implements CurrencyRepositoryInterface
{

    public function __construct(protected Currency $model)
    {
    }

    public function getAllCurrency(): \Illuminate\Support\Collection
    {
        return $this->model::query()
            ->pluck('code')
            ->map(function ($code) {
                return ['value' => $code];
            });
    }
}
