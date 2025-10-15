<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Http\Resources\TopSliderResource;
use App\Repositories\Contracts\MakerRepositoryInterface;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Repositories\Contracts\TransportRepositoryInterface;

class HomeController extends Controller
{
    public function __construct(
        private MakerRepositoryInterface $makerRepository,
        private TransportRepositoryInterface $transportRepository,
        private NewsRepositoryInterface $newsRepository
    ) {
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
