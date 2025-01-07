<?php

namespace App\Services;

use App\Http\Resources\AdminTransportResource;
use App\Models\Transport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class AdminTransportService
{
    public function getAllTransports()
    {
        $cacheKey = 'admin_all_transports';

        $cachedTransports = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return Transport::query()
                ->with(['maker', 'model', 'fuelType', 'user', 'images'])
                ->orderBy('published_at', 'desc')
                ->get([
                    'id',
                    'active',
                    'maker_id',
                    'model_id',
                    'fuel_type_id',
                    'transport_type_id',
                    'city',
                    'year',
                    'power',
                    'engine',
                    'fuel_supply_type',
                    'mileage',
                    'price',
                    'description',
                    'user_id',
                    'published_at'
                ]);
        });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $countItemsInPage = 5;
        $currentPageItems = $cachedTransports->slice(($currentPage - 1) * $countItemsInPage, $countItemsInPage)->all();
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $cachedTransports->count(),
            $countItemsInPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query()
            ]
        );

        return AdminTransportResource::collection($paginatedItems);
    }

    public function updateTransport($id)
    {
        $transport = Transport::query()->findOrFail($id);

        $transport->update(['active' => !$transport->active]);
    }

    public function destroyTransport($id)
    {
        Transport::query()
            ->where(['id' => $id])
            ->delete();
    }
}
