<?php

namespace App\Repositories;

use App\Models\Notifications;
use Illuminate\Notifications\DatabaseNotification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function __construct(protected Notifications $model)
    {
    }

    public function unReadNotification(string $id): \Illuminate\Http\JsonResponse
    {
        $notification = DatabaseNotification::query()->findOrFail($id);

        if ($notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    public function destroyNotifications(): void
    {
        $this->model::query()
            ->where('notifiable_id', Auth::user()->id)
            ->forceDelete();
    }
}
