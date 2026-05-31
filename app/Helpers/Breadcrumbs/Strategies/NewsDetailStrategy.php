<?php

namespace App\Helpers\Breadcrumbs\Strategies;

class NewsDetailStrategy extends AbstractBreadcrumbsStrategies
{
    public function generate($detailPage = null): array
    {
        return array_merge($this->home(), [
            ['title' => 'Новости', 'url' => route('news.index')],
            ['title' => $detailPage->title, 'url' => null]
        ]);
    }
}
