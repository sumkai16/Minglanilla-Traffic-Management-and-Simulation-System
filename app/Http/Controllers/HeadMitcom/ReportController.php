<?php
namespace App\Http\Controllers\HeadMitcom;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Notifications\ReportStatusUpdated;
use App\Notifications\ReportAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'duplicates'])
            ->whereNull('parent_id')
            ->latest()
            ->paginate(15);
        return view('head-mitcom.reports.index', compact('reports'));
    }
    public function show(Report $report)
    {
        $report->load(['user', 'duplicates.user', 'duplicates.verifier']);
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
        $enforcer = User::find($request->enforcer_id);
        $enforcer->notify(new ReportAssigned($report));
        if ($report->user) {
            $report->user->notify(new ReportStatusUpdated($report, 'Your report "' . $report->title . '" has been assigned to an enforcer.'));
        }
        return back()->with('success', 'Report assigned successfully.');
    }
    public function reassign(Request $request, Report $report)
    {
        $request->validate(['enforcer_id' => 'required|exists:users,id']);
        $report->update([
            'assigned_to' => $request->enforcer_id,
            'assigned_at' => now(),
        ]);
        $enforcer = User::find($request->enforcer_id);
        $enforcer->notify(new ReportAssigned($report));
        return back()->with('success', 'Report reassigned successfully.');
    }
    public function verify(Report $report)
    {
        $report->update(['status' => 'verified']);
        if ($report->user) {
            $report->user->notify(new ReportStatusUpdated($report, 'Your report "' . $report->title . '" has been verified.'));
        }
        return back()->with('success', 'Report verified.');
    }
    public function reject(Report $report)
    {
        $report->update(['status' => 'rejected']);
        if ($report->user) {
            $report->user->notify(new ReportStatusUpdated($report, 'Your report "' . $report->title . '" has been rejected.'));
        }
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
        if ($report->user) {
            $report->user->notify(new ReportStatusUpdated($report, 'Your report "' . $report->title . '" has been resolved.'));
        }
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
        if ($report->assignedEnforcer) {
            $report->assignedEnforcer->notify(new ReportAssigned($report));
        }
        return back()->with('success', 'Proof rejected. Report sent back to enforcer.');
    }
}