<?php

namespace App\Http\Controllers;

use App\Services\HomeService;

class HomeController extends Controller
{
    protected HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $topSliderTransports = $this->homeService->getTransportsInTopSlider();
        $latestReviews = $this->homeService->getLatestReviews();

        return inertia('Home', ['topSliderTransports' => $topSliderTransports, 'latestReviews' => $latestReviews]);
    }
}
