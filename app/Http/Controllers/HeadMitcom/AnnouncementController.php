<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use App\Notifications\AnnouncementPublished;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with('author')
            ->latest()
            ->paginate(10);

        $totalAnnouncements = Announcement::count();
        $publishedAnnouncements = Announcement::where('is_published', true)->count();
        $draftAnnouncements = Announcement::where('is_published', false)->count();
        $urgentAnnouncements = Announcement::where('priority', 'urgent')->count();

        return view('head-mitcom.announcements.index', compact(
            'announcements',
            'totalAnnouncements',
            'publishedAnnouncements',
            'draftAnnouncements',
            'urgentAnnouncements'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateAnnouncement($request);
        $shouldPublish = $request->boolean('publish_now');

        $data = [
            ...$validated,
            'created_by' => $request->user()->id,
            'is_published' => $shouldPublish,
            'published_at' => $shouldPublish ? now() : null,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('announcements', 'public');
        }

        Announcement::create($data);

        return back()->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement): View
    {
        return view('head-mitcom.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $this->validateAnnouncement($request);
        $shouldPublish = $request->boolean('publish_now');

        $data = [
            ...$validated,
            'is_published' => $shouldPublish,
            'published_at' => $shouldPublish
                ? ($announcement->published_at ?? now())
                : null,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $data['image'] = $request->file('image')->store('announcements', 'public');
        }

        if ($request->boolean('remove_image') && $announcement->image) {
            Storage::disk('public')->delete($announcement->image);
            $data['image'] = null;
        }

        $announcement->update($data);

        return redirect()
            ->route('head-mitcom.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function publish(Announcement $announcement): RedirectResponse
    {
        $announcement->update([
            'is_published' => true,
            'published_at' => $announcement->published_at ?? now(),
        ]);

        $citizens = User::where('role', 'user')->get();
        \Illuminate\Support\Facades\Notification::send($citizens, new AnnouncementPublished($announcement));

        return back()->with('success', 'Announcement published.');
    }

    public function unpublish(Announcement $announcement): RedirectResponse
    {
        $announcement->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return back()->with('success', 'Announcement moved back to draft.');
    }

    private function validateAnnouncement(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'type' => ['required', 'in:traffic_advisory,road_closure,emergency,system_notice'],
            'priority' => ['required', 'in:normal,important,urgent'],
        ]);
    }
}
