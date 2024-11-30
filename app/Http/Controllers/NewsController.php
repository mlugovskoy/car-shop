<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Models\Comment;
use App\Models\News;
use App\Services\NewsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function storeComment(Request $request, $id)
    {
        $comment = Comment::query()
            ->create(
                [
                    'description' => $request->comment,
                    'user_id' => Auth::user()->id,
                    'city' => Auth::user()->city ?: null,
                    'published_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );

        $article = News::findOrFail($id);
        $article->comments()->attach($comment->id);
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
