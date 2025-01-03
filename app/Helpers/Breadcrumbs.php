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
        } elseif ($currentPage === 'transport') {
            $breadcrumbs[] = [
                'title' => 'Автомобили',
                'url' => null
            ];
        } elseif ($currentPage === 'transportDetail') {
            $breadcrumbs[] = [
                'title' => 'Автомобили',
                'url' => route('transport.index')
            ];
            $breadcrumbs[] = [
                'title' => $detailPage->maker->name . ' ' . $detailPage->model->name,
                'url' => null
            ];
        } elseif ($currentPage === 'favorites') {
            $breadcrumbs[] = [
                'title' => 'Закладки',
                'url' => null
            ];
        }

        return $breadcrumbs;
    }
}
