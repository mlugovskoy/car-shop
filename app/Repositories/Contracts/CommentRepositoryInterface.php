<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\News\NewsCommentsRequest;

interface CommentRepositoryInterface
{
    public function storeCommentForNews(NewsCommentsRequest $request);
}
