<?php

namespace App\Services;

use App\Models\Favorites;
use App\Models\Transport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

class FavoriteService
{
    public function getAllTransports()
    {
        $cacheKey = 'favorites_transports_all';

        return Cache::remember($cacheKey, now()->addMinutes(10), function () {
            $favorites = $this->getAllFavorites();

            $transports = collect();

            foreach ($favorites as $favorite) {
                $transports->push(
                    Transport::query()
                        ->with(['maker', 'model', 'fuelType', 'user', 'images'])
                        ->where('id', $favorite->transport_id)
                        ->get([
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
                        ])
                        ->first()
                );
            }

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

    public function getAllFavorites()
    {
        return Favorites::query()->where('user_id', auth()->id())->get();
    }

    public function removeCacheAllFavorites(): void
    {
        $cacheKey = 'favorites_transports_all';

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }
}
