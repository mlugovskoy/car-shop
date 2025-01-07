<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Http\Filters\TransportsFilters;
use App\Http\Requests\Transports\TransportsCreateRequest;
use App\Http\Requests\Transports\TransportsRequest;
use App\Models\Favorites;
use App\Services\TransportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
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
		$this->transportService->addFavorite($id);
	}

	public function removeFavorite($id): void
	{
		$this->transportService->removeFavorite($id);
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
	public function store(TransportsCreateRequest $request)
	{
		$transport = $this->transportService->storeTransport($request);

		$date = Date::parse($transport->published_at)->translatedFormat('d F H:i:s');

		Session::flash(
			'success',
			"Ваше объявление #$transport->id создано $date! <br> Ожидайте подтверждения администратора."
		);

		return Redirect::route('transport.index');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $section, string $id)
	{
		$transport = $this->transportService->getDetailTransport($section, $id);

		$favorite = $this->transportService->checkItemFavorite($id);

		$breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('transportDetail', $transport);

		return Inertia::render(
			'Transport/Show',
			['transport' => $transport, 'breadcrumbs' => $breadcrumbs, 'isFavorite' => $favorite]
		);
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
