<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $issueType = request()->string('issue_type')->toString();
        $status = request()->string('status')->toString();
        $sort = request()->string('sort')->toString();

        $validStatuses = ['pending', 'verified', 'assigned', 'resolved', 'rejected'];
        $sort = in_array($sort, ['latest', 'oldest'], true) ? $sort : 'latest';

        // Base query for the authenticated user's reports
        $reportsQuery = $user->reports()
            ->when($issueType !== '', function ($query) use ($issueType) {
                $query->where('issue_type', $issueType);
            })
            ->when(in_array($status, $validStatuses, true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', $sort === 'oldest' ? 'asc' : 'desc');

        // Paginated list of user's reports
        $reports = $reportsQuery->paginate(10)->withQueryString();

        $issueTypes = $user->reports()
            ->select('issue_type')
            ->distinct()
            ->orderBy('issue_type')
            ->pluck('issue_type')
            ->map(fn ($type) => [
                'value' => $type,
                'label' => Str::title(str_replace('_', ' ', $type)),
            ]);

        $statusOptions = collect($validStatuses)->map(fn ($value) => [
            'value' => $value,
            'label' => Str::title($value),
        ]);

        // Status counts for the stats cards
        $reportStats = Cache::remember("dashboard:user:{$user->id}:report-stats", now()->addSeconds(30), function () use ($user) {
            return $user->reports()
                ->selectRaw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count")
                ->selectRaw("SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified_count")
                ->selectRaw("SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved_count")
                ->first();
        });

        $pendingCount = (int) ($reportStats->pending_count ?? 0);
        $verifiedCount = (int) ($reportStats->verified_count ?? 0);
        $resolvedCount = (int) ($reportStats->resolved_count ?? 0);

        $urgentAnnouncement = Announcement::with('author')
            ->published()
            ->where('priority', 'urgent')
            ->first();

        $latestAnnouncements = Announcement::with('author')
            ->published()
            ->take(3)
            ->get();

        return view('user.dashboard', compact(
            'reports',
            'pendingCount',
            'verifiedCount',
            'resolvedCount',
            'urgentAnnouncement',
            'latestAnnouncements',
            'issueTypes',
            'statusOptions',
            'issueType',
            'status',
            'sort'
        ));
    }
}
