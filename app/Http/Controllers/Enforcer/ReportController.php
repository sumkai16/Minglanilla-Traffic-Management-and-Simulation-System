<?php

namespace App\Http\Controllers\Enforcer;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function show(Request $request, Report $report)
    {
        abort_unless((int) $report->assigned_to === (int) $request->user()->id, 403);

        $report->load(['user', 'assignedEnforcer', 'verifier']);

        return view('enforcer.reports.show', compact('report'));
    }
}
