<?php

namespace App\Http\Controllers\Enforcer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
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
    }
}
