<?php

namespace App\Http\Controllers\Enforcer;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('assigned_to', auth()->user()->id)
            ->orderByRaw("FIELD(status, 'assigned', 'for_verification', 'resolved')")
            ->latest()
            ->get();

        return view('enforcer.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
       if ($report->assigned_to !== auth()->user()->id) {
            abort(403);
        }

        return view('enforcer.reports.show', compact('report'));
    }

    public function submitProof(Request $request, Report $report)
    {
       if ($report->assigned_to !== auth()->user()->id) {
            abort(403);
        }

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