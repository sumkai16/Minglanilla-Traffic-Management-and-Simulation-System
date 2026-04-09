<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\User;

class EnforcerController extends Controller{
    public function index(){
       
    $enforcers = user::where('role', 'enforcer')
        ->withCount('assignedReports')
        ->latest()
        ->paginate(10);

        return view('head-mitcom.enforcers.index', compact('enforcers'));
    }
  public function show(User $user)
{
    $enforcer = $user;

    $assignedReports = $enforcer->assignedReports()
        ->latest()
        ->paginate(10);

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
        'avgResolutionMinutes',
        'totalRejections'
    ));
}
}