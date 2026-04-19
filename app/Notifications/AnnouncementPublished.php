<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AnnouncementPublished extends Notification
{
    use Queueable;

    public function __construct(public Announcement $announcement) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'New announcement: ' . $this->announcement->title,
            'announcement_id' => $this->announcement->id,
            'type' => $this->announcement->type ?? 'general',
            'url' => '/announcements/' . $this->announcement->id,
        ];
    }
}