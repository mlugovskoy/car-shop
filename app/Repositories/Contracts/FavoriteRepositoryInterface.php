<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface FavoriteRepositoryInterface
{
    public function getAllFavorites();

    public function getTransportIdsOfFavoritesToArray(?Collection $favorites);

    public function checkItemFavorite(string $id);

    public function storeFavorite(string $id);

    public function destroyFavorite(string $id);
}
