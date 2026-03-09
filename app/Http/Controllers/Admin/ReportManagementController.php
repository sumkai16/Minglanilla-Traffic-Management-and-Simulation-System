<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Report::with(['user', 'verifier'])->latest();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by issue type
        if ($request->filled('issue_type') && $request->issue_type !== 'all') {
            $query->where('issue_type', $request->issue_type);
        }

        $reports = $query->paginate(20)->withQueryString(); 

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //

        $report->load(['user','verifier']);
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    public function updateStatus(Request $request, Report $report){
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,rejected,assigned,resolved'
        ]);

        $report->status = $validated['status'];

        //If verified or rejected, record kung kinsa
        if(in_array($validated['status'],['verified','rejected'])){
            $report->verified_by = Auth::id();
            $report->verified_at = now();
        }

        $report->save();
        return redirect()->back()->with('success','Report status updated successfully');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
