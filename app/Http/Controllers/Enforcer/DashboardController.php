<?php

namespace App\Http\Controllers\Enforcer;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
<<<<<<< HEAD
        $enforcerId = auth()->id();

        $currentAssigned = Report::with('user')
            ->where('assigned_to', $enforcerId)
            ->where('status', 'assigned')
            ->latest('assigned_at')
            ->take(8)
            ->get();

        $assignmentHistory = Report::with('user')
            ->where('assigned_to', $enforcerId)
            ->whereIn('status', ['resolved', 'rejected'])
            ->latest('assigned_at')
            ->take(8)
            ->get();

        $assignedCount = Report::where('assigned_to', $enforcerId)->count();
        $activeCount = Report::where('assigned_to', $enforcerId)->where('status', 'assigned')->count();
        $resolvedCount = Report::where('assigned_to', $enforcerId)->where('status', 'resolved')->count();

        return view('enforcer.dashboard', compact(
            'currentAssigned',
            'assignmentHistory',
            'assignedCount',
            'activeCount',
            'resolvedCount'
        ));
=======
          $userId = auth()->user()->id;

        $assignedCount = \App\Models\Report::where('assigned_to', $userId)
            ->where('status', 'assigned')
            ->count();

        $forVerificationCount = \App\Models\Report::where('assigned_to', $userId)
            ->where('status', 'for_verification')
            ->count();

        $resolvedCount = \App\Models\Report::where('assigned_to', $userId)
            ->where('status', 'resolved')
            ->count();

    return view('enforcer.dashboard', compact('assignedCount', 'forVerificationCount', 'resolvedCount'));
>>>>>>> 1d914ef388f56be386049aad752c94290edbb82c
    }
}
