<?php

namespace App\Helpers\Breadcrumbs\Strategies;

class TransportStrategy extends AbstractBreadcrumbsStrategies
{
    public function generate($detailPage = null): array
    {
        return array_merge($this->home(), [
            ['title' => 'Автомобили', 'url' => null]
        ]);
    }
}
