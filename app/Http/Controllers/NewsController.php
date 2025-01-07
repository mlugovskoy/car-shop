<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Http\Requests\News\NewsCommentsRequest;
use App\Http\Requests\News\NewsRequest;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class NewsController extends Controller
{
    protected NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $news = $this->newsService->getAllNews();

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('news');

        return Inertia::render('News/Index', ['news' => $news, 'breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        $article = $this->newsService->storeArticle($request);

        $date = Date::parse($article->published_at)->translatedFormat('d F H:i:s');

        Session::flash(
            'success',
            "Ваша новость #$article->id создана $date! <br> Ожидайте подтверждения администратора."
        );

        $this->newsService->removeCacheAllNewsSection();

        return Redirect::route('news.index');
    }

    public function storeComment(NewsCommentsRequest $request, $id)
    {
        $this->newsService->storeArticleComment($request, $id);

        $this->newsService->removeCacheDetailArticle($id);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = $this->newsService->getDetailArticle($id);

        $breadcrumbs = (new Breadcrumbs())->generateBreadcrumbs('newsDetail', $article);

        return Inertia::render('News/Show', ['article' => $article, 'breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
