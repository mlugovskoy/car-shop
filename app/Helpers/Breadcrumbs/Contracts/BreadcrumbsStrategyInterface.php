<?php

namespace App\Helpers\Breadcrumbs\Contracts;

interface BreadcrumbsStrategyInterface
{
    public function generate($detailPage = null): array;
}
