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
    public function index(Request $request)
    {
        $reports = Report::with(['user', 'duplicates'])
            ->whereNull('parent_id')
            ->filter($request->only(['search', 'status', 'issue_type']))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'pending' => Report::whereNull('parent_id')->where('status', 'pending')->count(),
            'verified' => Report::whereNull('parent_id')->where('status', 'verified')->count(),
            'assigned' => Report::whereNull('parent_id')->where('status', 'assigned')->count(),
            'resolved' => Report::whereNull('parent_id')->where('status', 'resolved')->count(),
        ];

        return view('head-mitcom.reports.index', compact('reports', 'stats'));
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

    public function create()
    {
        return view('head-mitcom.reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'issue_type' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'reporter_name' => 'required|string|max:255',
            'reporter_email' => 'required|email|max:255',
            'reporter_phone' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        Report::create([
            ...$validated,
            'image_path' => $imagePath,
            'user_id' => null,
            'parent_id' => Report::findDuplicate($validated['issue_type'], $validated['latitude'], $validated['longitude'])?->id,
            'status' => 'verified',
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);

        return redirect()
            ->route('head-mitcom.reports.index')
            ->with('success', 'Incident report created and verified successfully.');
    }
}