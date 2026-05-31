<?php

namespace App\Helpers\Breadcrumbs\Strategies;

class FavoriteStrategy extends AbstractBreadcrumbsStrategies
{
    public function generate($detailPage = null): array
    {
        return array_merge($this->home(), [
            ['title' => 'Закладки', 'url' => null]
        ]);
    }
}
