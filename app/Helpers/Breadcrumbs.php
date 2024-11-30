<?php

namespace App\Helpers;

class Breadcrumbs
{
    public function generateBreadcrumbs($currentPage, $detailPage = null): array
    {
        $breadcrumbs[] = [
            'title' => 'Главная',
            'url' => route('home')
        ];

        if ($currentPage === 'news') {
            $breadcrumbs[] = [
                'title' => 'Новости',
                'url' => null
            ];
        } elseif ($currentPage === 'newsDetail') {
            $breadcrumbs[] = [
                'title' => 'Новости',
                'url' => route('news.index')
            ];
            $breadcrumbs[] = [
                'title' => $detailPage->title,
                'url' => null
            ];
        }

        return $breadcrumbs;
    }
}
