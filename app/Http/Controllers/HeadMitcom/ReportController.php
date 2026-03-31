<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
    public function confirmResolved(Report $report)
    {
        if ($report->status !== 'for_verification') {
            return back()->with('error', 'This report is not pending verification.');
        }

        $report->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Report marked as resolved.');
    }

public function rejectResolved(Report $report)
    {
        if ($report->status !== 'for_verification') {
            return back()->with('error', 'This report is not pending verification.');
        }

        $report->update([
            'status' => 'assigned',
            'proof_image' => null,
        ]);

        return back()->with('success', 'Proof rejected. Report sent back to enforcer.');
    }
}