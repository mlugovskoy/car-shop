<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Http\Filters\TransportsFilters;
use App\Http\Requests\Transports\TransportsRequest;
use App\Models\Favorites;
use App\Services\TransportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransportController extends Controller
{
    protected TransportService $transportService;

    public function __construct(TransportService $transportService)
    {
        $this->transportService = $transportService;
    }

    public function index(TransportsRequest $request, TransportsFilters $filters, $section = null)
    {
        $transports = $this->transportService->getAllTransport($request, $filters, $section);

        $fieldsFilters = $this->transportService->getFieldsToFilters();

        $favorites = $this->transportService->getFavorites();

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('transport');

        return Inertia::render(
            'Transport/Index',
            [
                'transports' => $transports,
                'countTransports' => count($transports),
                'favorites' => $favorites->keyBy('transport_id'),
                'fieldsFilters' => $fieldsFilters,
                'breadcrumbs' => $breadcrumbs
            ]
        );
    }

    public function addFavorite($id): void
    {
        Favorites::query()->create([
            'user_id' => auth()->id(),
            'transport_id' => $id,
        ]);
    }

    public function removeFavorite($id): void
    {
        Favorites::query()
            ->where('transport_id', $id)
            ->where('user_id', auth()->id())
            ->delete();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
