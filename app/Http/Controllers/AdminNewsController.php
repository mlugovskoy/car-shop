<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Repositories\NewsRepository;

class AdminNewsController extends Controller
{
    protected NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function index()
    {
        $news = $this->newsRepository->paginateNews($this->newsRepository->getAdminAllNews(), 10);

        return inertia(
            'Profile/Admin/News/Index', ['items' => NewsResource::collection($news)]
        );
    }

    public function update($id)
    {
        $resOneNews = $this->newsRepository->findOneNews($id);

        $this->newsRepository->updateCurrentNews($resOneNews);

        return redirect()->route('admin.news')->with('success', "Статья #$id обновлена.");
    }

    public function destroy($id)
    {
        $this->newsRepository->destroyCurrentNews($id);

        return redirect()->route('admin.news')->with('success', "Статья #$id удалена.");
    }
}
