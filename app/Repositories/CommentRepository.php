<?php

namespace App\Repositories;

use App\Http\Requests\News\NewsCommentsRequest;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CommentRepository implements CommentRepositoryInterface
{

    public function __construct(protected Comment $model)
    {
    }

    public function storeCommentForNews(NewsCommentsRequest $request): Comment
    {
        return $this->model::query()
            ->create(
                [
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'city' => Auth::user()->city ?: null,
                    'published_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );
    }
}
