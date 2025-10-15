<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\NotificationRepositoryInterface;

class NotificationController extends Controller
{
    public function __construct(private NotificationRepositoryInterface $notificationRepository)
    {
    }

    public function update(string $id): void
    {
        $this->notificationRepository->unReadNotification($id);
    }

    public function destroy(): void
    {
        $this->notificationRepository->destroyNotifications();
    }
}
