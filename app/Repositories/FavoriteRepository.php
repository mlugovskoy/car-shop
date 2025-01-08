<?php

namespace App\Repositories;

use App\Helpers\ClearCache;
use App\Models\Favorites;
use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    protected int $cacheTime = 10;

    public function __construct(protected Favorites $model, protected ClearCache $cacheHelper)
    {
    }

    public function getAllFavorites(): Collection
    {
        $cacheKey = 'all_favorites';

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () {
            return $this->model::query()
                ->where('user_id', auth()->id())->get();
        });
    }

    public function getTransportIdsOfFavoritesToArray(?Collection $favorites): ?array
    {
        return $favorites?->pluck('transport_id')->toArray();
    }

    public function checkItemFavorite(string $id): bool
    {
        $cacheKey = 'favorite_item_' . $id;

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () use ($id) {
            $favorites = $this->model::query()
                ->where('user_id', auth()->id())
                ->where('transport_id', $id)
                ->get();

            return $favorites->count() > 0;
        });
    }

    public function storeFavorite(string $id): void
    {
        $this->model::query()
            ->create([
                'user_id' => auth()->id(),
                'transport_id' => $id,
            ]);

        $this->cacheHelper->removeSectionCache(['all_favorites', 'transports_of_favorites', 'favorite_item_' . $id]);
    }

    public function destroyFavorite(string $id): void
    {
        $this->model::query()
            ->where('transport_id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        $this->cacheHelper->removeSectionCache(['all_favorites', 'transports_of_favorites', 'favorite_item_' . $id]);
    }
}
