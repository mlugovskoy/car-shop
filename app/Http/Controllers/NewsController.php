<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\ClearCache;
use App\Http\Requests\News\NewsCommentsRequest;
use App\Http\Requests\News\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Repositories\CommentRepository;
use App\Repositories\NewsRepository;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class NewsController extends Controller
{
    protected NewsRepository $newsRepository;
    protected CommentRepository $commentRepository;

    public function __construct(NewsRepository $newsRepository, CommentRepository $commentRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        $news = $this->newsRepository->paginateNews($this->newsRepository->getAllNews(), 10);

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('news');

        return Inertia::render('News/Index', ['news' => NewsResource::collection($news), 'breadcrumbs' => $breadcrumbs]
        );
    }

    public function store(NewsRequest $request)
    {
        $article = $this->newsRepository->storeOneNews($request);

        Session::flash(
            'success',
            "Ваша новость #$article->id создана $article->published_at! <br> Ожидайте подтверждения администратора."
        );

        return Redirect::route('news.index');
    }

    public function storeComment(NewsCommentsRequest $request, $id)
    {
        $newComment = $this->commentRepository->storeCommentForNews($request);

        $oneNews = $this->newsRepository->findOneNews($id);

        $this->newsRepository->attachCommentForNews($newComment, $oneNews, $id);

        return Redirect::back();
    }

    public function show(string $id)
    {
        $oneNews = $this->newsRepository->getDetailNews($id);

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('newsDetail', $oneNews);

        return Inertia::render('News/Show', ['article' => new NewsResource($oneNews), 'breadcrumbs' => $breadcrumbs]);
    }
}
