<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminNewsController extends Controller
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    public function index(): Response|ResponseFactory
    {
        $news = $this->newsRepository->paginateNews($this->newsRepository->getAdminAllNews(), 10);

        return inertia('Profile/Admin/News/Index', ['items' => NewsResource::collection($news)]);
    }

    public function update($id): RedirectResponse
    {
        $resOneNews = $this->newsRepository->findOneNews($id);

        $this->newsRepository->updateCurrentNews($resOneNews);

        return redirect()->route('admin.news')->with('success', "Статья #$id обновлена.");
    }

    public function destroy($id): RedirectResponse
    {
        $this->newsRepository->destroyCurrentNews($id);

        return redirect()->route('admin.news')->with('success', "Статья #$id удалена.");
    }
}
