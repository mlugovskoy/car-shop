<?php

namespace App\Services;

use App\Http\Resources\AdminNewsResource;
use App\Models\News;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class AdminNewsService
{
    public function getAllNews()
    {
        $cacheKey = 'admin_all_news';

        $cachedNews = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return News::query()
                ->with(['user', 'images'])
                ->orderBy('published_at', 'desc')
                ->get(['id', 'active', 'title', 'description', 'user_id', 'published_at']);
        });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $countItemsInPage = 5;
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

        return AdminNewsResource::collection($paginatedItems);
    }

    public function updateArticle($id)
    {
        $article = News::query()->findOrFail($id);

        $article->update(['active' => !$article->active]);
    }

    public function destroyArticle($id)
    {
        News::query()
            ->where(['id' => $id])
            ->delete();
    }
}
