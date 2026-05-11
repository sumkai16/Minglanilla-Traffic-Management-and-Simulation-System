<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class CitizenReportController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array($request->user()->role, ['user', 'enforcer'])) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $reports = Report::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reports);
    }

    public function store(Request $request)
    {
        if (!in_array($request->user()->role, ['user', 'enforcer'])) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $request->validate([
            'issue_type'  => 'required|string',
            'description' => 'required|string',
            'location'    => 'required|string',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'image'       => 'nullable|image|max:5048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        $duplicate = Report::findDuplicate(
            $request->issue_type,
            $request->latitude,
            $request->longitude
        );

        $report = Report::create([
            'user_id'     => $request->user()->id,
            'issue_type'  => $request->issue_type,
            'description' => $request->description,
            'location'    => $request->location,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'image_path'  => $imagePath,
            'status'      => 'pending',
            'parent_id'   => $duplicate?->id,
            'reporter_ip' => $request->ip(),
        ]);

        return response()->json([
            'message' => 'Report submitted successfully.',
            'report'  => $report,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        if (!in_array($request->user()->role, ['user', 'enforcer'])) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $report = Report::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($report);
    }

    public function mapPins(Request $request)
    {
        if (!in_array($request->user()->role, ['user', 'enforcer'])) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $reports = Report::whereNotIn('status', ['resolved', 'rejected'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'issue_type', 'status', 'latitude', 'longitude', 'location']);

        return response()->json($reports);
    }
}