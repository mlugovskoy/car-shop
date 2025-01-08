<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\News\NewsCommentsRequest;

interface CommentRepositoryInterface
{

    public function storeCommentForNews(NewsCommentsRequest $request);
}
