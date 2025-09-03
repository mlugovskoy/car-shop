<?php

namespace App\Repositories;

use App\Http\Requests\News\NewsRequest;
use App\Models\Comment;
use App\Models\Image;
use App\Models\News;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Services\CacheService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsRepository implements NewsRepositoryInterface
{
    public function __construct(protected News $model)
    {
    }

    public function getHomeNews(int $limit = 5): Collection
    {
        $item = $this->model
            ->query()
            ->with(['images', 'comments'])
            ->orderBy('published_at', 'desc')
            ->where('active', true)
            ->limit($limit)
            ->get(['id', 'title', 'description', 'published_at']);

        return CacheService::save($item, $this->model::HOME_CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function getAllNews(): Collection
    {
        $item = $this->model
            ->query()
            ->where('active', true)
            ->orderBy('published_at', 'desc')
            ->get(['title', 'id', 'description', 'published_at']);

        return CacheService::save($item, $this->model::CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function getAdminAllNews(): Collection
    {
        $item = $this->model
            ->query()
            ->with(['user', 'images'])
            ->orderBy('published_at', 'desc')
            ->get(['id', 'active', 'title', 'description', 'user_id', 'published_at']);

        return CacheService::save($item, $this->model::ADMIN_CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function getDetailNews(int $id)
    {
        $item = $this->model
            ->query()
            ->with(['comments', 'images', 'user'])
            ->where('id', $id)
            ->first();

        return CacheService::save($item, $this->model::DETAIL_CACHE_KEY . "_$id", $this->model::CACHE_TIME);
    }

    public function attachCommentForNews(Comment $commentCollection, News $newsCollection, $id): void
    {
        $newsCollection->comments()->attach($commentCollection->id);

        CacheService::deleteItem($this->model::DETAIL_CACHE_KEY . "_$id");
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
        $oneNews = $this->model
            ->query()
            ->create([
                'active' => false,
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'published_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

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

        CacheService::deleteItems([$this->model::CACHE_KEY, $this->model::ADMIN_CACHE_KEY]);

        return $oneNews;
    }

    public function findOneNews(int $id): News
    {
        return $this->model
            ->query()
            ->findOrFail($id);
    }

    public function updateCurrentNews(News $oneNewsCollection): void
    {
        $oneNewsCollection->update(['active' => !$oneNewsCollection->active]);

        $user = User::query()->find($oneNewsCollection->user_id);
        $user->notify(
            new DatabaseNotification(
                "Администратор изменил статус вашей статьи <b>$oneNewsCollection->title</b>"
            )
        );

        CacheService::deleteItems([$this->model::CACHE_KEY, $this->model::ADMIN_CACHE_KEY]);
    }

    public function destroyCurrentNews(int $id): void
    {
        $news = $this->model
            ->query()
            ->where(['id' => $id])
            ->get(['user_id', 'title']);

        $user = User::query()->find($news->user_id);
        $user->notify(
            new DatabaseNotification(
                "Администратор удалил вашу статью <b>$news->title</b>"
            )
        );

        $this->model
            ->query()
            ->where(['id' => $id])
            ->delete();

        CacheService::deleteItems([$this->model::CACHE_KEY, $this->model::ADMIN_CACHE_KEY]);
    }
}
