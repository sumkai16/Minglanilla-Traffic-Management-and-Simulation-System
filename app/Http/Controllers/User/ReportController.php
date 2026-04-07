<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ReportController extends Controller
{
    //
    public function create(){
        return view('user.reports.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'issue_type' => 'required|in:traffic_signal_problem,road_damage,illegal_parking,traffic_obstruction,accident,traffic_violation,reckless_driving,public_safety,infrastructure',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $validated['user_id'] = Auth::user()->id;
        $validated['status'] = 'pending';

        // Duplicate detection
        $parentReport = Report::where('issue_type', $validated['issue_type'])
            ->whereNull('parent_id')
            ->whereNotIn('status', ['resolved', 'rejected'])
            ->where('created_at', '>=', now()->subHours(12))
            ->orderByRaw("(POW(latitude - ?, 2) + POW(longitude - ?, 2)) ASC", [$validated['latitude'], $validated['longitude']])
            ->first();

        if ($parentReport) {
            $distance = $this->calculateDistance(
                $validated['latitude'],
                $validated['longitude'],
                $parentReport->latitude,
                $parentReport->longitude
            );

            if ($distance <= 50) { // 50 meters threshold
                $validated['parent_id'] = $parentReport->id;
            }
        }

        if($request->hasFile('image')){
            $path = $request->file('image')->store('reports', 'public');
            $validated['image_path'] = $path;
        }

        Report::create($validated);

        return redirect()->route('user.dashboard')->with('success', 'Report submitted successfully.');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function show(Report $report){
            
        //user can only see their own reports
        if($report->user_id !== Auth::id()){
            abort(403, 'Unauthorized access. You do not have permission to view this report.');
        }    
        return  view('user.reports.show', compact('report'));
    }
}
