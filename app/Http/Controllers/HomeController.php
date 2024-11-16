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
        $latestNews = $this->homeService->getLatestNews();
        $makers = $this->homeService->getMakers();

        return inertia(
            'Home',
            [
                'topSliderTransports' => $topSliderTransports,
                'makers' => $makers,
                'latestReviews' => $latestReviews,
                'latestNews' => $latestNews
            ]
        );
    }
}
