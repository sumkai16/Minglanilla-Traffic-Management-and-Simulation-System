<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with('author')
            ->published()
            ->paginate(12);

        $urgentAnnouncement = Announcement::with('author')
            ->published()
            ->where('priority', 'urgent')
            ->first();

        return view('user.announcements.index', compact('announcements', 'urgentAnnouncement'));
    }
}
