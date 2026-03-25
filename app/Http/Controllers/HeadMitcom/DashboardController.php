<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalReports = Report::count();
        $verifiedReports = Report::where('status', 'verified')->count();
        $assignedReports = Report::where('status', 'assigned')->count();
        $resolvedReports = Report::where('status', 'resolved')->count();
        $activeEnforcers = User::where('role', 'enforcer')->count();

        // Recent verified reports (ready for assignment)
        $recentVerified = Report::where('status', 'verified')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent assigned reports
        $recentAssigned = Report::where('status', 'assigned')
            ->with(['user', 'assignedEnforcer'])
            ->latest()
            ->take(5)
            ->get();

        return view('head-mitcom.dashboard', compact(
            'totalReports',
            'verifiedReports',
            'assignedReports',
            'resolvedReports',
            'activeEnforcers',
            'recentVerified',
            'recentAssigned'
        ));
    }
}