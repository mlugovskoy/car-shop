<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Image;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NewsService
{
    public function getDetailArticle($id)
    {
        $cacheKey = 'detail_news_section_' . $id;

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($id) {
            $article = News::query()
                ->with(['comments', 'images'])
                ->where('id', $id)
                ->first();

            foreach ($article->comments as $comment) {
                $comment->userName = $comment->user->name;
                $comment->userImage = $comment->user->images;
                $comment->published_at = Carbon::parse($comment->published_at)->translatedFormat('d.m.Y');
            }

            $article->userName = $article->user->name;
            $article->published_at = Carbon::parse($article->published_at)->translatedFormat('d F');

            return $article;
        });
    }

    public function storeArticle($request)
    {
        $article = News::query()
            ->create(
                [
                    'active' => false,
                    'title' => $request->title,
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'published_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $image_path = $imageFile->store('images/news', 'public');
                $image = Image::query()->create([
                    'image_title' => $imageFile->getClientOriginalName(),
                    'image_path' => '/storage/' . $image_path,
                    'image_size' => $imageFile->getSize(),
                    'image_ext' => $imageFile->getMimeType(),
                    'image_source' => 'news',
                ]);
                $article->images()->attach($image->id);
            }
        }

        return $article;
    }

    public function storeArticleComment($request, $id): void
    {
        $comment = Comment::query()
            ->create(
                [
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'city' => Auth::user()->city ?: null,
                    'published_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );

        $article = News::query()->findOrFail($id);
        $article->comments()->attach($comment->id);
    }
}
