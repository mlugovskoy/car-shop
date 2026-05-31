<?php

namespace App\Helpers\Breadcrumbs\Strategies;

use App\Helpers\Breadcrumbs\Contracts\BreadcrumbsStrategyInterface;

abstract class AbstractBreadcrumbsStrategies implements BreadcrumbsStrategyInterface
{
    protected function home(): array
    {
        return [['title' => 'Главная', 'url' => route('home')]];
    }
}
