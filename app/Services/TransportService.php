<?php

namespace App\Services;

use App\Models\Transport;
use Illuminate\Support\Facades\Cache;

class TransportService
{
    public function getAllTransport($request, $filters)
    {
        $this->removeCacheAllTransportSection();

        $cacheKey = 'all_transport_section';

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request, $filters) {
            return Transport::query()
                ->where('active', true)
                ->orderBy('published_at', 'desc')
                ->filter($filters)
                ->get(
                    [
                        'id',
                        'maker_id',
                        'model_id',
                        'city',
                        'power',
                        'engine',
                        'fuel_type_id',
                        'mileage',
                        'price',
                        'color',
                        'user_id',
                        'transport_type_id',
                        'published_at'
                    ]
                );
        });
    }

    public function getFieldsToFilters()
    {
        $cacheKey = 'fields_to_filters_section';

        $transports = Transport::query()
            ->where('active', true)
            ->get();

        $makers = $transports->pluck('maker')->unique()->map(function ($maker) {
            return ['value' => $maker['name']];
        })->values()->all();

        $models = $transports->pluck('model')->unique()->map(function ($model) {
            return ['value' => $model['name']];
        })->values()->all();

        $steeringWheel = $transports->pluck('steering_wheel')->unique()->map(function ($steeringWheel) {
            return $steeringWheel;
        })->values()->all();

        $transmission = $transports->pluck('transmission')->unique()->map(function ($transmission) {
            return ['value' => $transmission];
        })->values()->all();

        $drive = $transports->pluck('drive')->unique()->map(function ($drive) {
            return ['value' => $drive];
        })->values()->all();

        $color = $transports->pluck('color')->unique()->map(function ($color) {
            return ['value' => $color];
        })->values()->all();

        $fuelType = $transports->pluck('fuelType')->unique()->map(function ($fuelType) {
            return ['value' => $fuelType['name']];
        })->values()->all();

        $transportType = $transports->pluck('transportType')->unique()->map(function ($transportType) {
            return ['value' => $transportType['name']];
        })->values()->all();

        $year = $transports->pluck('year')->unique()->sort()->map(function ($year) {
            return ['value' => $year];
        })->values()->all();

        return [
            'makers' => $makers,
            'models' => $models,
            'steeringWheel' => $steeringWheel,
            'transmission' => $transmission,
            'drive' => $drive,
            'color' => $color,
            'fuelType' => $fuelType,
            'transportType' => $transportType,
            'year' => $year,
        ];
    }

    public function removeCacheAllTransportSection(): void
    {
        $cacheKey = 'all_transport_section';

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }

    public function removeCacheFieldsToFilters(): void
    {
        $cacheKey = 'all_transport_section';

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }
}
