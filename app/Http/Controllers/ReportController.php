<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Show the public report form
    public function create()
    {
        return view('reports.create');
    }

    // Store a new report
    public function store(Request $request)
    {
        // If guest, check if they already reported with this email
        if (!Auth::check()) {
            $existingReport = Report::whereNull('user_id')
                ->where('reporter_email', $request->email)
                ->exists();

            if ($existingReport) {
                return back()->with('error', 'You have already submitted a report. Please login to submit more.');
            }
        }

        $validated = $request->validate([
            'issue_type' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            // Guest fields - only required if not logged in
            'reporter_name' => Auth::check() ? 'nullable' : 'required|string|max:255',
            'reporter_email' => Auth::check() ? 'nullable' : 'required|email|max:255',
            'reporter_phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',      
            
        ]);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        $validated['image_path'] = $imagePath;
        // If logged in, use user_id and clear guest fields
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
            $validated['reporter_name'] = null;
            $validated['reporter_email'] = null;
            $validated['reporter_phone'] = null;
        } else {
            // Guest report
            $validated['user_id'] = null;
        }

        Report::create($validated);

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }
   // Get reports for map display
    public function mapData()
    {
        $reports = Report::with('user')
            ->where('status', '!=', 'rejected')
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'latitude' => (float) $report->latitude,
                    'longitude' => (float) $report->longitude,
                    'issue_type' => $report->issue_type,
                    'description' => $report->description,
                    'location' => $report->location,
                    'status' => $report->status,
                    'created_at' => $report->created_at->diffForHumans(),
                ];
            });

        return response()->json($reports);
    }


 public function confirmation()
    {
        return view('reports.confirmation');
    }
}