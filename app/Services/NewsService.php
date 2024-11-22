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

    public function getDetailArticle($id)
    {
        $cacheKey = 'detail_news_section_' . $id;

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($id) {
            $article = News::query()
                ->with(['comments', 'images'])
                ->where('id', $id)
                ->first();

            foreach ($article->comments as $comment) {
                $comment->userName = $comment->user->name;
                $comment->userImage = $comment->user->images;
                $comment->published_at = Carbon::parse($comment->published_at)->translatedFormat('d.m.Y');
            }

            $article->userName = $article->user->name;
            $article->published_at = Carbon::parse($article->published_at)->translatedFormat('d F');

            return $article;
        });
    }

    public function removeCacheDetailArticle($id)
    {
        $cacheKey = 'detail_news_section_' . $id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }
}
