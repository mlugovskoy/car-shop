<?php

namespace App\Services;

use App\Models\Favorites;
use App\Models\FuelType;
use App\Models\Image;
use App\Models\Maker;
use App\Models\Model;
use App\Models\Transport;
use App\Models\TransportType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransportService
{
    public function getAllTransport($request, $filters, $section)
    {
        if (!empty($section)) {
            $maker = Maker::query()->where('name', 'ilike', $section)->first('id');
        } else {
            $maker = false;
        }

        $transports = Transport::query()
            ->with(['maker', 'model', 'fuelType', 'user', 'images'])
            ->where('active', true)
            ->when($maker, function ($query) use ($maker) {
                return $query->where('maker_id', $maker->id);
            })
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

            $transport->price = number_format($transport->price, 0, '.', ' ') . ' ₽';
        }

        return $transports;
    }

    public function storeTransport($request)
    {
        $transport = Transport::query()
            ->create(
                [
                    'active' => false,
                    'city' => $request->city,
                    'vin' => $request->vin,
                    'phone' => $request->phone,
                    'description' => $request->description,
                    'engine' => $request->engine,
                    'power' => $request->power,
                    'transmission' => $request->transmission,
                    'drive' => $request->drive,
                    'mileage' => $request->mileage,
                    'color' => $request->color,
                    'steering_wheel' => $request->steering_wheel,
                    'country' => $request->country,
                    'tact' => $request->tact,
                    'fuel_supply_type' => $request->fuel_supply_type,
                    'doors' => $request->doors,
                    'seats' => $request->seats,
                    'price' => $request->price,
                    'year' => $request->year,
                    'model_id' => Model::query()->where('name', 'ilike', $request->models)->pluck('id')->first(),
                    'maker_id' => Maker::query()->where('name', 'ilike', $request->makers)->pluck('id')->first(),
                    'fuel_type_id' => FuelType::query()->where('name', 'ilike', $request->fuel_type_id)->pluck(
                        'id'
                    )->first(),
                    'transport_type_id' => TransportType::query()->where(
                        'name',
                        'ilike',
                        $request->transport_type_id
                    )->pluck('id')->first(),
                    'user_id' => auth()->id(),
                    'published_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $image_path = $imageFile->store('images/transports', 'public');
                $image = Image::query()->create([
                    'image_title' => $imageFile->getClientOriginalName(),
                    'image_path' => '/storage/' . $image_path,
                    'image_size' => $imageFile->getSize(),
                    'image_ext' => $imageFile->getMimeType(),
                    'image_source' => 'transports',
                ]);
                $transport->images()->attach($image->id);
            }
        }

        return $transport;
    }

    public function getFieldsToFilters()
    {
        $cacheKey = 'fields_to_filters_section';

        return Cache::remember($cacheKey, now()->addMinutes(10), function () {
            $transports = Transport::query()
                ->where('active', true)
                ->get();

            $makers = $transports->pluck('maker')->unique()->whereNotNull()->map(function ($maker) {
                return ['value' => $maker['name']];
            })->values()->all();

            $models = $transports->pluck('model')->unique()->whereNotNull()->map(function ($model) {
                return ['value' => $model['name']];
            })->values()->all();

            $steeringWheel = $transports->pluck('steering_wheel')->unique()->whereNotNull()->map(
                function ($steeringWheel) {
                    return $steeringWheel;
                }
            )->values()->all();

            $transmission = $transports->pluck('transmission')->unique()->whereNotNull()->map(function ($transmission) {
                return ['value' => $transmission];
            })->values()->all();

            $drive = $transports->pluck('drive')->unique()->whereNotNull()->map(function ($drive) {
                return ['value' => $drive];
            })->values()->all();

            $color = $transports->pluck('color')->unique()->whereNotNull()->map(function ($color) {
                return ['value' => $color];
            })->values()->all();

            $fuelType = $transports->pluck('fuelType')->unique()->whereNotNull()->map(function ($fuelType) {
                return ['value' => $fuelType['name']];
            })->values()->all();

            $transportType = $transports->pluck('transportType')->unique()->whereNotNull()->map(
                function ($transportType) {
                    return ['value' => $transportType['name']];
                }
            )->values()->all();

            $year = $transports->pluck('year')->unique()->whereNotNull()->sort()->map(function ($year) {
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
        });
    }

    public function getFavorites(): \Illuminate\Database\Eloquent\Collection
    {
        $cacheKey = 'favorites_all';

        return Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return Favorites::query()->where('user_id', auth()->id())->get();
        });
    }

    public function checkItemFavorite($id)
    {
        $favorites = Favorites::query()
            ->where('user_id', auth()->id())
            ->where('transport_id', $id)
            ->get();

        if ($favorites->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function removeFavorite(string $id): void
    {
        $this->removeCacheAllFavorites();
        (new FavoriteService())->removeCacheAllFavorites();

        Favorites::query()
            ->where('transport_id', $id)
            ->where('user_id', auth()->id())
            ->delete();
    }

    public function addFavorite(string $id): void
    {
        $this->removeCacheAllFavorites();
        (new FavoriteService())->removeCacheAllFavorites();

        Favorites::query()->create([
            'user_id' => auth()->id(),
            'transport_id' => $id,
        ]);
    }

    public function getDetailTransport(string $section, string $id)
    {
        if (!empty($section)) {
            $maker = Maker::query()->where('name', 'ilike', $section)->first('id');
        } else {
            $maker = false;
        }

        $transport = Transport::query()
            ->with(['maker', 'model', 'fuelType', 'user', 'images'])
            ->where('active', true)
            ->where('id', $id)
            ->when($maker, function ($query) use ($maker) {
                return $query->where('maker_id', $maker->id);
            })
            ->orderBy('published_at', 'desc')
            ->first([
                'id',
                'maker_id',
                'model_id',
                'fuel_type_id',
                'transport_type_id',

                'year',
                'city',
                'power',
                'engine',
                'transmission',
                'drive',
                'mileage',
                'color',
                'steering_wheel',
                'phone',
                'price',
                'description',

                'fuel_supply_type',
                'user_id',
                'published_at'
            ]);

        $transport->published_at = Date::parse($transport->published_at)->translatedFormat('d F');

        $transport->preview = $transport->power . ' л.с, '
            . $transport->fuelType->name
            . ', ' . $transport->fuel_supply_type
            . ', ' . $transport->mileage . ' км';

        $transport->price = number_format($transport->price, 0, '.', ' ') . ' ₽';
        $transport->mileage = number_format($transport->mileage, 0, '.', ' ');
        $transport->power = number_format($transport->power, 0, '.', ' ');

        return $transport;
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

    public function removeCacheAllFavorites(): void
    {
        $cacheKey = 'favorites_all';

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }
}
