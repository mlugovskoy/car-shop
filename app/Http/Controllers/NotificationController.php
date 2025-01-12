<?php

namespace App\Http\Controllers;


use App\Models\Notifications;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
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
