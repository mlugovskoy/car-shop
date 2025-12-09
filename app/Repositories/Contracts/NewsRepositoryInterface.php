<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\News\NewsRequest;
use App\Models\News;
use Illuminate\Support\Collection;

interface NewsRepositoryInterface
{
    public function getHomeNews(int $limit);

    public function getAllNews();

    public function getAdminAllNews();

    public function paginateNews(Collection $newsCollection, int $perPage);

    public function storeOneNews(NewsRequest $request);

    public function findOneNews(int $id);

    public function updateCurrentNews(News $oneNewsCollection);

    public function destroyCurrentNews(int $id);
}
