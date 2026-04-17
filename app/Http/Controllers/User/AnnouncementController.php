<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $query = Announcement::with('author')->published();

        if (request('type')) {
            $query->where('type', request('type'));
        }

        $announcements = $query->paginate(12)->withQueryString();

        $urgentAnnouncement = Announcement::with('author')
            ->published()
            ->where('priority', 'urgent')
            ->first();

        return view('user.announcements.index', compact('announcements', 'urgentAnnouncement'));
    }
}
