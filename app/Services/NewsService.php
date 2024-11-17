<?php

namespace App\Services;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class NewsService
{
    public function getAllNews(): LengthAwarePaginator
    {
        $cacheKey = 'all_news_section';

        $cachedNews = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return News::query()
                ->orderBy('published_at', 'desc')
                ->get(['title', 'id', 'description', 'published_at']);
        });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $countItemsInPage = 10;
        $currentPageItems = $cachedNews->slice(($currentPage - 1) * $countItemsInPage, $countItemsInPage)->all();
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $cachedNews->count(),
            $countItemsInPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query()
            ]
        );

        foreach ($paginatedItems as $article) {
            foreach ($article->images as $image) {
                $article->push($image);
            }
            foreach ($article->comments as $comment) {
                $article->push($comment);
            }
            $article->published_at = Carbon::parse($article->published_at)->translatedFormat('d F');
        }

        return $paginatedItems;
    }
}
