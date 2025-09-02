<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Http\Filters\TransportsFilters;
use App\Http\Requests\Transports\TransportsCreateRequest;
use App\Http\Resources\TransportResource;
use App\Repositories\FavoriteRepository;
use App\Repositories\MakerRepository;
use App\Repositories\TransportRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class TransportController extends Controller
{
    protected TransportRepository $transportRepository;
    protected MakerRepository $makerRepository;
    protected FavoriteRepository $favoriteRepository;

    public function __construct(
        TransportRepository $transportRepository,
        MakerRepository $makerRepository,
        FavoriteRepository $favoriteRepository
    ) {
        $this->makerRepository = $makerRepository;
        $this->favoriteRepository = $favoriteRepository;
        $this->transportRepository = $transportRepository;
    }

    public function index(TransportsFilters $filters, $section = null)
    {
        $maker = $this->makerRepository->getMakerId($section);

        $transports = $this->transportRepository->getAllTransportsToFilters($filters, $maker);

        $fieldsFilters = $this->transportRepository->getFieldsToFilters();

        $favorites = $this->favoriteRepository->getAllFavorites();

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('transport');

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

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('transportDetail', $transport);

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
