<?php

namespace App\Http\Controllers\Enforcer;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Support\Facades\Cache;
use App\Models\EnforcerStation;
class DashboardController extends Controller
{
    public function index()
    {
        $enforcerId = auth()->id();

        $currentAssigned = Report::with('user')
            ->where('assigned_to', $enforcerId)
            ->whereIn('status', ['assigned', 'for_verification'])
            ->latest('assigned_at')
            ->take(8)
            ->get();

        $assignmentHistory = Report::with('user')
            ->where('assigned_to', $enforcerId)
            ->whereIn('status', ['resolved', 'rejected'])
            ->latest('assigned_at')
            ->take(8)
            ->get();

        $reportStats = Cache::remember("dashboard:enforcer:{$enforcerId}:report-stats", now()->addSeconds(30), function () use ($enforcerId) {
            return Report::query()
                ->where('assigned_to', $enforcerId)
                ->selectRaw('COUNT(*) as assigned_count')
                ->selectRaw("SUM(CASE WHEN status = 'assigned' THEN 1 ELSE 0 END) as active_count")
                ->selectRaw("SUM(CASE WHEN status = 'for_verification' THEN 1 ELSE 0 END) as for_verification_count")
                ->selectRaw("SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved_count")
                ->first();
        });

        $assignedCount = (int) ($reportStats->assigned_count ?? 0);
        $activeCount = (int) ($reportStats->active_count ?? 0);
        $forVerificationCount = (int) ($reportStats->for_verification_count ?? 0);
        $resolvedCount = (int) ($reportStats->resolved_count ?? 0);
        $currentStation = EnforcerStation::where('enforcer_id', $enforcerId)
            ->where('is_active', true)
            ->latest('assigned_at')
            ->first();
        return view('enforcer.dashboard', compact(
            'currentAssigned',
            'assignmentHistory',
            'assignedCount',
            'activeCount',
            'forVerificationCount',
            'resolvedCount',
            'currentStation',
        ));
    }
}
