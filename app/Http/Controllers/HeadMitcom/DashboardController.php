<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $reportStats = Cache::remember('dashboard:head-mitcom:report-stats', now()->addSeconds(60), function () {
            return Report::query()
                ->selectRaw('COUNT(*) as total_reports')
                ->selectRaw("SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified_reports")
                ->selectRaw("SUM(CASE WHEN status = 'assigned' THEN 1 ELSE 0 END) as assigned_reports")
                ->selectRaw("SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved_reports")
                ->first();
        });

        $systemStats = Cache::remember('dashboard:head-mitcom:system-stats', now()->addSeconds(60), function () {
            return [
                'active_enforcers' => User::where('role', 'enforcer')->count(),
                'published_announcements' => Announcement::where('is_published', true)->count(),
            ];
        });

        $totalReports = (int) ($reportStats->total_reports ?? 0);
        $verifiedReports = (int) ($reportStats->verified_reports ?? 0);
        $assignedReports = (int) ($reportStats->assigned_reports ?? 0);
        $resolvedReports = (int) ($reportStats->resolved_reports ?? 0);
        $activeEnforcers = (int) ($systemStats['active_enforcers'] ?? 0);
        $publishedAnnouncements = (int) ($systemStats['published_announcements'] ?? 0);

        // Recent verified reports (ready for assignment)
        $recentVerified = Report::where('status', 'verified')
            ->with('user:id,first_name,last_name,email')
            ->latest()
            ->take(5)
            ->get();

        // Recent assigned reports
        $recentAssigned = Report::where('status', 'assigned')
            ->with([
                'user:id,first_name,last_name,email',
                'assignedEnforcer:id,first_name,last_name,email',
            ])
            ->latest()
            ->take(5)
            ->get();

        $recentAnnouncements = Announcement::with('author:id,first_name,last_name,email')
            ->latest()
            ->take(3)
            ->get();

        return view('head-mitcom.dashboard', compact(
            'totalReports',
            'verifiedReports',
            'assignedReports',
            'resolvedReports',
            'activeEnforcers',
            'publishedAnnouncements',
            'recentVerified',
            'recentAssigned',
            'recentAnnouncements'
        ));
    }

    public function map()
    {
        return view('head-mitcom.map');
    }
}
