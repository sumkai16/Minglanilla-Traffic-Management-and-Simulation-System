<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class EnforcerReportController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->user()->role !== 'enforcer') {
    return response()->json(['message' => 'Unauthorized.'], 403);
}
        $reports = Report::where('assigned_to', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reports);
    }

    public function updateStatus(Request $request, $id)
    {
        if ($request->user()->role !== 'enforcer') {
    return response()->json(['message' => 'Unauthorized.'], 403);
}
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,rejected',
        ]);

        $report = Report::where('id', $id)
            ->where('assigned_to', $request->user()->id)
            ->firstOrFail();

        $report->update([
            'status'      => $request->status,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        return response()->json([
            'message' => 'Status updated.',
            'report'  => $report,
        ]);
    }

    public function addRemarks(Request $request, $id)
    {
        if ($request->user()->role !== 'enforcer') {
    return response()->json(['message' => 'Unauthorized.'], 403);
}
        $request->validate([
            'proof_remarks' => 'required|string',
        ]);

        $report = Report::where('id', $id)
            ->where('assigned_to', $request->user()->id)
            ->firstOrFail();

        $report->update([
            'proof_remarks' => $request->proof_remarks,
        ]);

        return response()->json([
            'message' => 'Remarks added.',
            'report'  => $report,
        ]);
    }
}