<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
{
    // Fetch published announcements
    $announcementQuery = Announcement::with('author')->published();
    
    if (request('search')) {
        $search = request('search');
        $announcementQuery->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('content', 'LIKE', "%{$search}%");
        });
    }

    if (request('type')) {
        if (request('type') === 'traffic_advisory') {
            $announcements = collect();
        } else {
            $announcements = $announcementQuery->where('type', request('type'))->get();
        }
    } else {
        $announcements = $announcementQuery->get();
    }

    // Fetch published advisories and normalize to match announcement structure
    $advisories = collect();
    if (!request('type') || request('type') === 'traffic_advisory') {
        $advisoryQuery = \App\Models\TrafficAdvisory::with('creator')
            ->where('status', 'published');
            
        if (request('search')) {
            $search = request('search');
            $advisoryQuery->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
            
        $advisories = $advisoryQuery->get()
            ->map(function ($advisory) {
                return (object) [
                    'id'           => 'advisory-' . $advisory->id,
                    'title'        => $advisory->title,
                    'content'      => $advisory->description ?? 'No description provided.',
                    'type'         => 'traffic_advisory',
                    'priority'     => 'important',
                    'image'        => null,
                    'published_at' => $advisory->start_date->startOfDay(),
                    'author'       => $advisory->creator,
                    'is_advisory'  => true,
                    'map_data'     => $advisory->map_data,
                ];
            });
    }

    // Merge, sort by published_at descending, paginate manually
    $merged = $announcements->map(function ($a) {
        $a->is_advisory = false;
        return $a;
    })
    ->concat($advisories)
    ->sortByDesc('published_at')
    ->values();

    $perPage = 12;
    $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
    $paginatedItems = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $announcements = new \Illuminate\Pagination\LengthAwarePaginator(
        $paginatedItems,
        $merged->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $urgentAnnouncement = Announcement::with('author')
        ->published()
        ->where('priority', 'urgent')
        ->first();

    $prefix = auth()->user()->role === 'enforcer' ? 'enforcer' : 'user';

    return view('user.announcements.index', compact('announcements', 'urgentAnnouncement', 'prefix'));
}
public function show(string $announcement): View
{
    // Handle traffic advisories (ID format: "advisory-{id}")
    if (str_starts_with($announcement, 'advisory-')) {
        $advisoryId = (int) str_replace('advisory-', '', $announcement);
        $advisory = \App\Models\TrafficAdvisory::with('creator')->findOrFail($advisoryId);

        if ($advisory->status !== 'published') {
            abort(404);
        }

        // Normalize to the same shape the show view expects
        $announcement = (object) [
            'id'           => 'advisory-' . $advisory->id,
            'title'        => $advisory->title,
            'content'      => $advisory->description ?? 'No description provided.',
            'type'         => 'traffic_advisory',
            'priority'     => 'important',
            'image'        => null,
            'published_at' => $advisory->start_date?->startOfDay(),
            'author'       => $advisory->creator,
            'is_advisory'  => true,
            'map_data'     => $advisory->map_data,
            'start_date'   => $advisory->start_date,
            'end_date'     => $advisory->end_date,
        ];

        $prefix = auth()->user()->role === 'enforcer' ? 'enforcer' : 'user';
        return view('user.announcements.show', compact('announcement', 'prefix'));
    }

    // Regular announcement
    $announcement = Announcement::findOrFail($announcement);

    if (!$announcement->is_published) {
        abort(404);
    }

    $announcement->load('author');

    $prefix = auth()->user()->role === 'enforcer' ? 'enforcer' : 'user';
    return view('user.announcements.show', compact('announcement', 'prefix'));
}
}
