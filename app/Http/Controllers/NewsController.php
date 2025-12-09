<?php

namespace App\Http\Controllers;

use App\Helpers\Contracts\BreadcrumbsInterface;
use App\Http\Requests\News\NewsCommentsRequest;
use App\Http\Requests\News\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Repositories\Contracts\CommentRepositoryInterface;
use App\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
        private CommentRepositoryInterface $commentRepository,
        private BreadcrumbsInterface $breadcrumbs
    ) {
    }

    public function index(): Response
    {
        $news = $this->newsRepository->paginateNews($this->newsRepository->getAllNews(), 10);

        $breadcrumbs = $this->breadcrumbs->generateBreadcrumbs('news');

        return Inertia::render('News/Index', ['news' => NewsResource::collection($news), 'breadcrumbs' => $breadcrumbs]
        );
    }

    public function store(NewsRequest $request): RedirectResponse
    {
        $article = $this->newsRepository->storeOneNews($request);

        Session::flash(
            'flash',
            "Ваша новость #$article->id создана $article->published_at! <br> Ожидайте подтверждения администратора."
        );

        return Redirect::route('news.index');
    }

    public function storeComment(NewsCommentsRequest $request, $id): RedirectResponse
    {
        $newComment = $this->commentRepository->storeCommentForNews($request);

        $oneNews = $this->newsRepository->findOneNews($id);

        $this->newsRepository->attachCommentForNews($newComment, $oneNews, $id);

        return Redirect::back();
    }

    public function show(string $id): Response
    {
        $oneNews = $this->newsRepository->getDetailNews($id);

        $breadcrumbs = $this->breadcrumbs->generateBreadcrumbs('newsDetail', $oneNews);

        return Inertia::render('News/Show', ['article' => new NewsResource($oneNews), 'breadcrumbs' => $breadcrumbs]);
    }
}
