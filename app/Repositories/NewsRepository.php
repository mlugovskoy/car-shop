<?php

namespace App\Repositories;

use App\Helpers\ClearCache;
use App\Http\Requests\News\NewsRequest;
use App\Models\Comment;
use App\Models\Image;
use App\Models\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class NewsRepository implements NewsRepositoryInterface
{
    protected int $cacheTime = 10;

    public function __construct(protected News $model, protected ClearCache $cacheHelper)
    {
    }

    public function getHomeNews(int $limit = 5): Collection
    {
        $cacheKey = 'home_news';

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () use ($limit) {
            return $this->model::query()
                ->with(['images', 'comments'])
                ->orderBy('published_at', 'desc')
                ->where('active', true)
                ->limit($limit)
                ->get(['id', 'title', 'description', 'published_at']);
        });
    }

    public function getAllNews(): Collection
    {
        $cacheKey = 'all_news';

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () {
            return $this->model::query()
                ->where('active', true)
                ->orderBy('published_at', 'desc')
                ->get(['title', 'id', 'description', 'published_at']);
        });
    }

    public function getAdminAllNews(): Collection
    {
        $cacheKey = 'admin_all_news';

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () {
            return $this->model::query()
                ->with(['user', 'images'])
                ->orderBy('published_at', 'desc')
                ->get(['id', 'active', 'title', 'description', 'user_id', 'published_at']);
        });
    }

    public function getDetailNews(int $id)
    {
        $cacheKey = 'detail_news' . $id;

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () use ($id) {
            return $this->model::query()
                ->with(['comments', 'images', 'user'])
                ->where('id', $id)
                ->first();
        });
    }

    public function attachCommentForNews(Comment $commentCollection, News $newsCollection, $id): void
    {
        $newsCollection->comments()->attach($commentCollection->id);

        $this->cacheHelper->removeSectionCache('detail_news' . $id);
    }

    public function paginateNews(Collection $newsCollection, int $perPage = 5): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $newsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new LengthAwarePaginator(
            $currentPageItems,
            $newsCollection->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query()
            ]
        );
    }

    public function storeOneNews(NewsRequest $request)
    {
        $oneNews = $this->model::query()
            ->create(
                [
                    'active' => false,
                    'title' => $request->title,
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'published_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $image_path = Storage::disk('public')->put('images/news', $imageFile);
                $image = Image::query()->create([
                    'image_title' => $imageFile->getClientOriginalName(),
                    'image_path' => $image_path,
                    'image_size' => $imageFile->getSize(),
                    'image_ext' => $imageFile->getMimeType(),
                    'image_source' => 'news',
                ]);
                $oneNews->images()->attach($image->id);
            }
        }

        $this->cacheHelper->removeSectionCache(['all_news', 'admin_all_news']);

        return $oneNews;
    }

    public function findOneNews(int $id): News
    {
        return $this->model::query()
            ->findOrFail($id);
    }

    public function updateCurrentNews(News $oneNewsCollection): void
    {
        $oneNewsCollection->update(['active' => !$oneNewsCollection->active]);

        $this->cacheHelper->removeSectionCache(['all_news', 'admin_all_news', 'latest_news']);
    }

    public function destroyCurrentNews(int $id): void
    {
        $this->model
            ->query()
            ->where(['id' => $id])
            ->delete();

        $this->cacheHelper->removeSectionCache(['all_news', 'admin_all_news', 'latest_news']);
    }
}
