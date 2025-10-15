<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\Contracts\BreadcrumbsInterface;
use App\Http\Filters\TransportsFilters;
use App\Http\Requests\Transports\TransportsCreateRequest;
use App\Http\Resources\TransportResource;
use App\Repositories\Contracts\FavoriteRepositoryInterface;
use App\Repositories\Contracts\MakerRepositoryInterface;
use App\Repositories\Contracts\TransportRepositoryInterface;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TransportController extends Controller
{
    public function __construct(
        private TransportRepositoryInterface $transportRepository,
        private MakerRepositoryInterface $makerRepository,
        private FavoriteRepositoryInterface $favoriteRepository,
        private BreadcrumbsInterface $breadcrumbs
    ) {
    }

    public function index(TransportsFilters $filters, $section = null)
    {
        $maker = $this->makerRepository->getMakerId($section);

        $transports = $this->transportRepository->getAllTransportsToFilters($filters, $maker);

        $fieldsFilters = $this->transportRepository->getFieldsToFilters();

        $favorites = $this->favoriteRepository->getAllFavorites();

        $breadcrumbs = $this->breadcrumbs->generateBreadcrumbs('transport');

        return Inertia::render(
            'Transport/Index',
            [
                'transports' => TransportResource::collection($transports),
                'countTransports' => count($transports),
                'favorites' => $favorites->keyBy('transport_id'),
                'fieldsFilters' => $fieldsFilters,
                'breadcrumbs' => $breadcrumbs
            ]
        );
    }

    public function addFavorite($id): void
    {
        $this->favoriteRepository->storeFavorite($id);
    }

    public function removeFavorite($id): void
    {
        $this->favoriteRepository->destroyFavorite($id);
    }

    public function store(TransportsCreateRequest $request)
    {
        $this->transportRepository->storeTransport($request);

        return Redirect::route('transport.index');
    }

    public function show(string $section, string $id)
    {
        $maker = $this->makerRepository->getMakerId($section);

        $transport = $this->transportRepository->getOneTransportToFilters($maker, $id);

        $favorite = $this->favoriteRepository->checkItemFavorite($id);

        $breadcrumbs = $this->breadcrumbs->generateBreadcrumbs('transportDetail', $transport);

        return Inertia::render(
            'Transport/Show',
            [
                'transport' => new TransportResource($transport),
                'breadcrumbs' => $breadcrumbs,
                'isFavorite' => $favorite
            ]
        );
    }
}
