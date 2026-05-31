<?php

namespace App\Helpers\Breadcrumbs\Strategies;

class TransportDetailStrategy extends AbstractBreadcrumbsStrategies
{
    public function generate($detailPage = null): array
    {
        return array_merge($this->home(), [
            ['title' => 'Автомобили', 'url' => route('transport.index')],
            ['title' => $detailPage->maker->name . ' ' . $detailPage->model->name, 'url' => null]
        ]);
    }
}
