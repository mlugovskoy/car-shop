<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\News\NewsCommentsRequest;

interface NotificationRepositoryInterface
{
    public function unReadNotification(string $id);

    public function destroyNotifications();
}
