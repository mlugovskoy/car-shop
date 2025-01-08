<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\ClearCache;
use App\Http\Requests\News\NewsCommentsRequest;
use App\Http\Requests\News\NewsRequest;
use App\Http\Resources\NewsResource;
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

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
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
        $this->newsService->storeArticleComment($request, $id);

        (new ClearCache())->removeSectionCache('detail_news_section_' . $id);

        return Redirect::back();
    }

    public function show(string $id)
    {
        $article = $this->newsService->getDetailArticle($id);

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('newsDetail', $article);

        return Inertia::render('News/Show', ['article' => $article, 'breadcrumbs' => $breadcrumbs]);
    }
}
