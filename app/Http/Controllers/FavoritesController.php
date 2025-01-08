<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Http\Resources\TransportResource;
use App\Repositories\FavoriteRepository;
use App\Repositories\TransportRepository;
use Inertia\Inertia;

class FavoritesController extends Controller
{
    protected FavoriteRepository $favoriteRepository;
    protected TransportRepository $transportRepository;

    public function __construct(FavoriteRepository $favoriteRepository, TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
        $this->favoriteRepository = $favoriteRepository;
    }

    public function index()
    {
        $favorites = $this->favoriteRepository->getAllFavorites();

        $transportIds = $this->favoriteRepository->getTransportIdsOfFavoritesToArray($favorites);

        $transports = $this->transportRepository->getTransportsOfFavorites($transportIds);

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('favorites');

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
