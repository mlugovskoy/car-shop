<?php

namespace App\Services;

use App\Http\Filters\TransportsFilter;
use App\Models\Transport;
use Illuminate\Support\Facades\Cache;

class TransportService
{
    public function getAllTransport($request)
    {
        $cacheKey = 'all_transport_section';

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $filter = app()->make(TransportsFilter::class, ['queryParams' => array_filter($request)]);
            return Transport::query()
//                ->where('active', true)
                ->orderBy('published_at', 'desc')
                ->filter($filter)
                ->get(['id', 'description', 'published_at']);
        });
//
//        $currentPage = LengthAwarePaginator::resolveCurrentPage();
//        $countItemsInPage = 10;
//        $currentPageItems = $cachedNews->slice(($currentPage - 1) * $countItemsInPage, $countItemsInPage)->all();
//        $paginatedItems = new LengthAwarePaginator(
//            $currentPageItems,
//            $cachedNews->count(),
//            $countItemsInPage,
//            $currentPage,
//            [
//                'path' => LengthAwarePaginator::resolveCurrentPath(),
//                'query' => request()->query()
//            ]
//        );
//
//        return $paginatedItems;
    }

    public function removeCacheAllTransportSection(): void
    {
        $cacheKey = 'all_transport_section';

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }
}
