<?php

namespace App\Helpers\Contracts;

interface BreadcrumbsInterface
{
    public function generateBreadcrumbs($currentPage, $detailPage = null): array;
}
