<?php

namespace App\Helpers;

use App\Helpers\Breadcrumbs\Contracts\BreadcrumbsInterface;
use App\Helpers\Breadcrumbs\Strategies\FavoriteStrategy;
use App\Helpers\Breadcrumbs\Strategies\NewsDetailStrategy;
use App\Helpers\Breadcrumbs\Strategies\NewsStrategy;
use App\Helpers\Breadcrumbs\Strategies\TransportDetailStrategy;
use App\Helpers\Breadcrumbs\Strategies\TransportStrategy;

class BreadcrumbsContext implements BreadcrumbsInterface
{
    private array $strategies = [
        'news' => NewsStrategy::class,
        'newsDetail' => NewsDetailStrategy::class,
        'transport' => TransportStrategy::class,
        'transportDetail' => TransportDetailStrategy::class,
        'favorites' => FavoriteStrategy::class,
    ];

    public function generateBreadcrumbs(string $currentPage, $detailPage = null): array
    {
        $strategyClass = $this->strategies[$currentPage] ?? null;

        if (!$strategyClass) {
            return [['title' => 'Главная', 'url' => route('home')]];
        }

        return (new $strategyClass())->generate($detailPage);
    }
}
