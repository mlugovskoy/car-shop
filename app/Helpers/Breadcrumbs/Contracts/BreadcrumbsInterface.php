<?php

namespace App\Helpers\Breadcrumbs\Contracts;

interface BreadcrumbsInterface
{
    public function generateBreadcrumbs(string $currentPage, $detailPage = null): array;
}
