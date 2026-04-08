<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        Report::create([
            ...$validated,
            'image_path' => $imagePath,
            'user_id' => Auth::check() ? Auth::id() : null,
            'parent_id' => Report::findDuplicate($validated['issue_type'], $validated['latitude'], $validated['longitude'])?->id,
            'reporter_name' => Auth::check() ? null : $validated['reporter_name'],
            'reporter_email' => Auth::check() ? null : $validated['reporter_email'],
            'reporter_phone' => Auth::check() ? null : $validated['reporter_phone'],
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }
   // Get reports for map display
    public function mapData()
    {
        $reports = Cache::remember('reports:map-data:latest-50', now()->addSeconds(30), function () {
            return Report::query()
                ->select([
                    'id',
                    'latitude',
                    'longitude',
                    'issue_type',
                    'description',
                    'location',
                    'status',
                    'created_at',
                ])
                ->where('status', '!=', 'rejected')
                ->latest('created_at')
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
                })
                ->values()
                ->all();
        });

        return response()->json($reports);
    }


    public function confirmation()
    {
        return view('reports.confirmation');
    }

    public function checkDuplicate(Request $request)
    {
        $request->validate([
            'issue_type' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $duplicate = Report::findDuplicate(
            $request->issue_type,
            $request->latitude,
            $request->longitude
        );

        if ($duplicate) {
            return response()->json([
                'found' => true,
                'location' => $duplicate->location,
                'created_at' => $duplicate->created_at->diffForHumans() ?? $duplicate->created_at->toDateTimeString(),
            ]);
        }

        return response()->json(['found' => false]);
    }
}
