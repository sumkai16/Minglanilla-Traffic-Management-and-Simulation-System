<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\User;

class EnforcerController extends Controller{
    public function index(){
        $query = User::where('role', 'enforcer')
            ->withCount('assignedReports');

        // Search by name or email
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by assignment status
        if (request('assignment') === 'has_assignments') {
            $query->has('assignedReports');
        } elseif (request('assignment') === 'no_assignments') {
            $query->doesntHave('assignedReports');
        }

        // Sort
        $sortField = request('sort', 'created_at');
        $sortDir = request('dir', 'desc');
        $allowedSorts = ['first_name', 'created_at', 'assigned_reports_count'];
        $allowedDirs = ['asc', 'desc'];

        if (!in_array($sortField, $allowedSorts)) $sortField = 'created_at';
        if (!in_array($sortDir, $allowedDirs)) $sortDir = 'desc';

        $query->orderBy($sortField, $sortDir);

        $enforcers = $query->paginate(10)->withQueryString();

        return view('head-mitcom.enforcers.index', compact('enforcers'));
    }
    public function show(User $user)
    {
        $enforcer = $user;

        $assignedReports = $enforcer->assignedReports()
            ->latest()
            ->paginate(10);

        $totalAssigned = $enforcer->assignedReports()->count();

        $activeCount = $enforcer->assignedReports()
            ->where('status', 'assigned')
            ->count();

        $reviewCount = $enforcer->assignedReports()
            ->where('status', 'for_verification')
            ->count();

        $resolvedCount = $enforcer->assignedReports()
            ->where('status', 'resolved')
            ->count();

        $completionRate = $totalAssigned > 0
            ? round(($resolvedCount / $totalAssigned) * 100)
            : 0;

        $resolvedReports = $enforcer->assignedReports()
            ->whereNotNull('assigned_at')
            ->whereNotNull('resolved_at')
            ->where('status', 'resolved')
            ->get(['assigned_at', 'resolved_at']);

        $avgResolutionMinutes = $resolvedReports->avg(function ($r) {
            return $r->assigned_at->diffInMinutes($r->resolved_at);
        });
        $avgResolutionMinutes = $avgResolutionMinutes ? round($avgResolutionMinutes) : null;

        $totalRejections = $enforcer->assignedReports()->sum('rejection_count');

        return view('head-mitcom.enforcers.show', compact(
            'enforcer',
            'assignedReports',
            'totalAssigned',
            'activeCount',
            'reviewCount',
            'resolvedCount',
            'completionRate',
            'avgResolutionMinutes',
            'totalRejections'
        ));
    }
}