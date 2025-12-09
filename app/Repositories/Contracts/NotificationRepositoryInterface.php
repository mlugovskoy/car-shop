<?php

namespace App\Repositories\Contracts;

interface NotificationRepositoryInterface
{
    public function unReadNotification(string $id);

    public function destroyNotifications();
}
