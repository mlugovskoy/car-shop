<?php

namespace App\Http\Controllers;

use App\Helpers\RemoveSectionCache;
use App\Services\AdminNewsService;

class AdminNewsController extends Controller
{
    protected AdminNewsService $adminNewsService;

    public function __construct(AdminNewsService $adminNewsService)
    {
        $this->adminNewsService = $adminNewsService;
    }

    public function index()
    {
        $news = $this->adminNewsService->getAllNews();

        return inertia(
            'Profile/Admin/News/Index', ['items' => $news]
        );
    }

    public function update($id)
    {
        $this->adminNewsService->updateArticle($id);

        (new RemoveSectionCache())->removeSectionCache(['admin_all_news', 'latest_news']);

        return redirect()->route('admin.news')->with('success', "Статья #$id обновлена.");
    }

    public function destroy($id)
    {
        $this->adminNewsService->destroyArticle($id);

        (new RemoveSectionCache())->removeSectionCache(['admin_all_news', 'latest_news']);

        return redirect()->route('admin.news')->with('success', "Статья #$id удалена.");
    }
}
