<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Http\Resources\TopSliderResource;
use App\Repositories\MakerRepository;
use App\Repositories\NewsRepository;
use App\Repositories\TransportRepository;

class HomeController extends Controller
{
    protected MakerRepository $makerRepository;
    protected TransportRepository $transportRepository;
    protected NewsRepository $newsRepository;

    public function __construct(
        MakerRepository $makerRepository,
        TransportRepository $transportRepository,
        NewsRepository $newsRepository
    ) {
        $this->makerRepository = $makerRepository;
        $this->transportRepository = $transportRepository;
        $this->newsRepository = $newsRepository;
    }

    public function index()
    {
        $topSliderTransports = $this->transportRepository->getTopSliderTransports();

        $makers = $this->makerRepository->getMakersAttachedToTransport(
            $this->transportRepository->getMakerIdsAttachedTransports()
        );

        $latestNews = $this->newsRepository->getHomeNews();

        return inertia(
            'Home',
            [
                'topSliderTransports' => TopSliderResource::collection($topSliderTransports),
                'makers' => $makers,
                'latestNews' => NewsResource::collection($latestNews)
            ]
        );
    }
}
