<?php

namespace App\Services\Notifications;

use App\Models\Notification;
use App\Models\User;

class NotificationDispatcher
{
    public function inApp(User $user, string $type, string $title, string $body, array $data = []): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'channel' => 'in_app',
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => $data,
            'status' => 'pending',
        ]);
    }
}
