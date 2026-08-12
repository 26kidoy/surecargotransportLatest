<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;

class NotificationHelper
{
    public static function send($userId, $type, $title, $message, $data = [], $actionUrl = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'action_url' => $actionUrl,
            'is_read' => false,
        ]);
    }

    public static function sendToUser($user, $type, $title, $message, $data = [], $actionUrl = null)
    {
        if (is_numeric($user)) {
            $userId = $user;
        } else {
            $userId = $user->id;
        }

        return self::send($userId, $type, $title, $message, $data, $actionUrl);
    }

    /**
     * Send a notification about an announcement to all users.
     *
     * @param \App\Models\Announcement $announcement
     * @param string $action  'created' or 'updated'
     * @return void
     */
    public static function sendAnnouncementNotification($announcement, $action = 'created')
    {
        // Optionally filter users (e.g., exclude admins)
        $users = User::all(); // or User::whereIn('user_type', ['customer', 'poultry_owner'])->get();

        $title = $action === 'created' ? '📢 New Announcement' : '📢 Announcement Updated';
        $message = $action === 'created'
            ? "A new announcement '{$announcement->title}' has been posted."
            : "The announcement '{$announcement->title}' has been updated.";

        $data = [
            'announcement_id' => $announcement->id,
            'action'          => $action,
        ];

        $actionUrl = route('announcements.index');

        foreach ($users as $user) {
            self::send(
                $user->id,
                'announcement',      // type
                $title,
                $message,
                $data,
                $actionUrl
            );
        }
    }
}
