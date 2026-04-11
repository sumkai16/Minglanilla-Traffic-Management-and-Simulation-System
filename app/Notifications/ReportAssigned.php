<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportAssigned extends Notification
{
    use Queueable;

    public function __construct(public Report $report) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'title'     => $this->report->title,
            'status'    => $this->report->status,
            'message'   => 'You have been assigned a new traffic report: ' . $this->report->title,
        ];
    }
    
}