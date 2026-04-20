<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Models\Report;
use App\Models\TrafficAdvisory;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('dashboard:admin:user-stats', now()->addSeconds(60), function () {
            return User::query()
                ->selectRaw('COUNT(*) as total_users')
                ->selectRaw("SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admin_count")
                ->selectRaw("SUM(CASE WHEN role = 'head-mitcom' THEN 1 ELSE 0 END) as head_mitcom_count")
                ->selectRaw("SUM(CASE WHEN role = 'enforcer' THEN 1 ELSE 0 END) as enforcer_count")
                ->selectRaw("SUM(CASE WHEN role = 'user' THEN 1 ELSE 0 END) as user_count")
                ->first();
        });

        $totalUsers = (int) ($stats->total_users ?? 0);
        $adminCount = (int) ($stats->admin_count ?? 0);
        $headMitcomCount = (int) ($stats->head_mitcom_count ?? 0);
        $enforcerCount = (int) ($stats->enforcer_count ?? 0);
        $userCount = (int) ($stats->user_count ?? 0);

        return view('admin.dashboard', compact(
            'totalUsers',
            'adminCount',
            'headMitcomCount',
            'enforcerCount',
            'userCount'
        ));
    }
    public function map(){
        return view('admin.map');
    }
    public function system()
    {
        $reportStats = Cache::remember('dashboard:admin:report-stats', now()->addSeconds(60), function () {
            return Report::query()
                ->selectRaw('COUNT(*) as total')
                ->selectRaw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending")
                ->selectRaw("SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified")
                ->selectRaw("SUM(CASE WHEN status = 'assigned' THEN 1 ELSE 0 END) as assigned")
                ->selectRaw("SUM(CASE WHEN status = 'for_verification' THEN 1 ELSE 0 END) as for_verification")
                ->selectRaw("SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved")
                ->selectRaw("SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected")
                ->first();
        });

        $totalReports = (int) ($reportStats->total ?? 0);
        $resolvedReports = (int) ($reportStats->resolved ?? 0);
        $pendingReports = (int) ($reportStats->pending ?? 0);
        $assignedReports = (int) ($reportStats->assigned ?? 0);
        $rejectedReports = (int) ($reportStats->rejected ?? 0);
        $resolutionRate = $totalReports > 0 ? round(($resolvedReports / $totalReports) * 100) : 0;

        $advisoryStats = Cache::remember('dashboard:admin:advisory-stats', now()->addSeconds(60), function () {
            return TrafficAdvisory::query()
                ->selectRaw('COUNT(*) as total')
                ->selectRaw("SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published")
                ->selectRaw("SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft")
                ->selectRaw("SUM(CASE WHEN status = 'archived' THEN 1 ELSE 0 END) as archived")
                ->first();
        });

        $totalAdvisories = (int) ($advisoryStats->total ?? 0);
        $publishedAdvisories = (int) ($advisoryStats->published ?? 0);
        $draftAdvisories = (int) ($advisoryStats->draft ?? 0);
        $archivedAdvisories = (int) ($advisoryStats->archived ?? 0);

        $enforcerCount = User::where('role', 'enforcer')->count();
        $activeEnforcers = User::where('role', 'enforcer')
            ->whereHas('assignedReports', function ($q) {
                $q->whereIn('status', ['assigned', 'for_verification']);
            })->count();

        $lastReport = Report::latest()->first();
        $lastAdvisory = TrafficAdvisory::latest()->first();

        return view('admin.system', compact(
            'totalReports',
            'resolvedReports',
            'pendingReports',
            'assignedReports',
            'rejectedReports',
            'resolutionRate',
            'totalAdvisories',
            'publishedAdvisories',
            'draftAdvisories',
            'archivedAdvisories',
            'enforcerCount',
            'activeEnforcers',
            'lastReport',
            'lastAdvisory',
        ));
    }
    public function auditLog(Request $request)
    {
        $query = Activity::with('causer', 'subject')->latest();

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('subject')) {
            $query->where('subject_type', 'like', '%' . $request->subject . '%');
        }

        if ($request->filled('causer')) {
            $query->whereHasMorph('causer', '*', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->causer . '%')
                  ->orWhere('last_name', 'like', '%' . $request->causer . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20)->withQueryString();

        $enforcers = \App\Models\User::where('role', 'enforcer')
            ->select('id', 'first_name', 'last_name')
            ->get()
            ->keyBy('id');

        // Dynamically fetch available events and subjects for the filters
        $events = Activity::select('event')->distinct()->pluck('event')->filter()->values();
        
        $subjects = Activity::select('subject_type')
            ->whereNotNull('subject_type')
            ->distinct()
            ->pluck('subject_type')
            ->map(fn($type) => class_basename($type))
            ->unique()
            ->values();

        $allUsers = User::select('id', 'first_name', 'last_name', 'email', 'role', 'created_at')->get();

        return view('admin.audit-log', compact('logs', 'enforcers', 'events', 'subjects', 'allUsers'));
    }
}
