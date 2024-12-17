<?php

namespace App\Services;

use App\Models\Transport;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use XMLReader;

class TransportService
{
    public function getAllTransport($request, $filters)
    {
        $this->removeCacheAllTransportSection();

        $cacheKey = 'all_transport_section';

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request, $filters) {
            $transports = Transport::query()
                ->with(['maker', 'model', 'fuelType', 'user'])
                ->where('active', true)
                ->orderBy('published_at', 'desc')
                ->filter($filters)
                ->get(
                    [
                        'id',
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
                    ]
                );

            foreach ($transports as $transport) {
                $transport->published_at = Date::parse($transport->published_at)->translatedFormat('d F');

                $transport->preview = $transport->power . ' л.с, '
                    . $transport->fuelType->name
                    . ', ' . $transport->fuel_supply_type
                    . ', ' . $transport->mileage . ' км';

                $transport->price = number_format($transport->price, 0, '.', ' ') . ' ₽';
            }

            return $transports;
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

    private function getCurrencyCode(string $code): float
    {
        $res = '';
        try {
            if (Http::get('https://www.cbr-xml-daily.ru/daily.xml')->successful()) {
                $contentXml = Http::get('https://www.cbr-xml-daily.ru/daily.xml')->getBody()->getContents();
                $xmlObj = new \SimpleXMLElement($contentXml);

                foreach ($xmlObj->Valute as $value) {
                    if ($code === (string)$value->CharCode) {
                        $res = (float)$value->Value;
                    }
                }
            }
        } catch (\Exception $err) {
            Log::error($err->getMessage());
        }

        return $res;
    }
}
