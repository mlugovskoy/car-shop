<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Services\TransportService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportController extends Controller
{
    protected TransportService $transportService;

    public function __construct(TransportService $transportService)
    {
        $this->transportService = $transportService;
    }

    public function index()
    {
        $news = $this->transportService->getAllTransport();

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('transport');

        return Inertia::render('Transport/Index', ['transports' => $news, 'breadcrumbs' => $breadcrumbs]);
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
