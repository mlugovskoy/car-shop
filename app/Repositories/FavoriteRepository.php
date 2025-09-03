<?php

namespace App\Repositories;

use App\Models\Favorites;
use App\Repositories\Contracts\FavoriteRepositoryInterface;
use App\Services\CacheService;
use Illuminate\Support\Collection;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    public function __construct(protected Favorites $model)
    {
    }

    public function getAllFavorites(): Collection
    {
        $item = $this->model
            ->query()
            ->where('user_id', auth()->id())
            ->get();

        return CacheService::save($item, $this->model::CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function getTransportIdsOfFavoritesToArray(?Collection $favorites): ?array
    {
        return $favorites?->pluck('transport_id')->toArray();
    }

    public function checkItemFavorite(string $id): bool
    {
        $favorites = $this->model
            ->query()
            ->where('user_id', auth()->id())
            ->where('transport_id', $id)
            ->get();

        $isFavorite = $favorites->count() > 0;

        return CacheService::save($isFavorite, $this->model::DETAIL_CACHE_KEY . "_$id", $this->model::CACHE_TIME);
    }

    public function storeFavorite(string $id): void
    {
        $this->model
            ->query()
            ->create([
                'user_id' => auth()->id(),
                'transport_id' => $id,
            ]);

        CacheService::deleteItems([$this->model::CACHE_KEY, $this->model::DETAIL_CACHE_KEY . "_$id"]);
    }

    public function destroyFavorite(string $id): void
    {
        $this->model
            ->query()
            ->where('transport_id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        CacheService::deleteItems([$this->model::CACHE_KEY, $this->model::DETAIL_CACHE_KEY . "_$id"]);
    }
}
