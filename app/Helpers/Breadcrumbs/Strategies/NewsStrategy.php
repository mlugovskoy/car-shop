<?php

namespace App\Helpers\Breadcrumbs\Strategies;

class NewsStrategy extends AbstractBreadcrumbsStrategies
{
    public function generate($detailPage = null): array
    {
        return array_merge($this->home(), [
            ['title' => 'Новости', 'url' => null]
        ]);
    }
}
