<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\News\NewsCommentsRequest;

interface NotificationRepositoryInterface
{
    public function unReadNotification(string $id);

    public function destroyNotifications();
}
