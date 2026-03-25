<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('user')
            ->latest()
            ->paginate(15);

        return view('head-mitcom.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $enforcers = User::where('role', 'enforcer')->get();
        return view('head-mitcom.reports.show', compact('report', 'enforcers'));
    }

    public function assign(Request $request, Report $report)
    {
        $request->validate(['enforcer_id' => 'required|exists:users,id']);

        $report->update([
            'assigned_to' => $request->enforcer_id,
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Report assigned successfully.');
    }

    public function reassign(Request $request, Report $report)
    {
        $request->validate(['enforcer_id' => 'required|exists:users,id']);

        $report->update([
            'assigned_to' => $request->enforcer_id,
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Report reassigned successfully.');
    }
    public function verify(Report $report)
    {
        $report->update(['status' => 'verified']);
        return back()->with('success', 'Report verified.');
    }

    public function reject(Report $report)
    {
        $report->update(['status' => 'rejected']);
        return back()->with('success', 'Report rejected.');
    }
}