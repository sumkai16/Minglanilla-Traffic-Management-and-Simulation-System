<?php

namespace App\Http\Controllers\Enforcer;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $enforcerId = auth()->id();

        $reports = Report::with(['user', 'assignedEnforcer', 'verifier'])
            ->where('assigned_to', $enforcerId)
            ->filter(request()->only('search', 'status', 'issue_type'))
            ->orderByRaw("FIELD(status, 'assigned', 'for_verification', 'resolved', 'rejected')")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total'            => Report::where('assigned_to', $enforcerId)->count(),
            'assigned'         => Report::where('assigned_to', $enforcerId)->where('status', 'assigned')->count(),
            'for_verification' => Report::where('assigned_to', $enforcerId)->where('status', 'for_verification')->count(),
            'resolved'         => Report::where('assigned_to', $enforcerId)->where('status', 'resolved')->count(),
        ];

        return view('enforcer.reports.index', compact('reports', 'stats'));
    }

    public function show(Request $request, Report $report)
    {
        abort_unless((int) $report->assigned_to === (int) $request->user()->id, 403);

        $report->load(['user', 'assignedEnforcer', 'verifier']);

        return view('enforcer.reports.show', compact('report'));
    }

    public function submitProof(Request $request, Report $report)
    {
        abort_unless((int) $report->assigned_to === (int) $request->user()->id, 403);

        if ($report->status !== 'assigned') {
            return back()->with('error', 'This report cannot be updated at this stage.');
        }

        $request->validate([
            'proof_image' => ['required', 'image', 'max:5120'],
        ]);

        $path = $request->file('proof_image')->store('proof-images', 'public');

        $report->update([
            'proof_image' => $path,
            'status' => 'for_verification',
        ]);

        return back()->with('success', 'Proof submitted. Awaiting Head MITCOM verification.');
    }
}
