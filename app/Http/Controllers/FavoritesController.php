<?php

namespace App\Http\Controllers;

use App\Helpers\Contracts\BreadcrumbsInterface;
use App\Http\Resources\TransportResource;
use App\Repositories\Contracts\FavoriteRepositoryInterface;
use App\Repositories\Contracts\TransportRepositoryInterface;
use Inertia\Inertia;

class FavoritesController extends Controller
{
    public function __construct(
        private FavoriteRepositoryInterface $favoriteRepository,
        private TransportRepositoryInterface $transportRepository,
        private BreadcrumbsInterface $breadcrumbs
    ) {
    }

    public function index()
    {
        $favorites = $this->favoriteRepository->getAllFavorites();

        $transportIds = $this->favoriteRepository->getTransportIdsOfFavoritesToArray($favorites);

        $transports = $this->transportRepository->getTransportsOfFavorites($transportIds);

        $breadcrumbs = $this->breadcrumbs->generateBreadcrumbs('favorites');

        return Inertia::render(
            'Favorites/Index',
            [
                'transports' => TransportResource::collection($transports),
                'favorites' => $favorites,
                'breadcrumbs' => $breadcrumbs,
                'isFavoritePage' => true
            ]
        );
    }
}
