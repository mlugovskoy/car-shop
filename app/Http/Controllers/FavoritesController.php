<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Services\FavoriteService;
use Inertia\Inertia;

class FavoritesController extends Controller
{
    protected FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function index()
    {
        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('favorites');

        $transports = $this->favoriteService->getAllTransports();

        $favorites = $this->favoriteService->getAllFavorites();

        return Inertia::render(
            'Favorites/Index',
            [
                'transports' => $transports,
                'favorites' => $favorites,
                'breadcrumbs' => $breadcrumbs,
                'isFavoritePage' => true
            ]
        );
    }
}
