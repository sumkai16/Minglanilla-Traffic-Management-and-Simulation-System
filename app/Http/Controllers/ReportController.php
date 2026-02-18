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
        ]);

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

        return back()->with('success', 'Report submitted successfully. We will review it shortly.');
    }
}