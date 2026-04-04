<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\TrafficAdvisory;
use Carbon\Carbon;

class SimulationController extends Controller
{
    //
    public function index()
    {
        return view('head-mitcom.simulation');
    }
    public function data(Request $request)
    {
        $start = Carbon::parse($request->get('start', now()->subDays(30)->startOfDay()));
        $end = Carbon::parse($request->get('end', now()->endOfDay()));

        $reports = Report::whereBetween('created_at', [$start, $end])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'issue_type', 'location', 'latitude', 'longitude', 'status', 'created_at', 'verified_at', 'assigned_at', 'resolved_at']);

        $advisories = TrafficAdvisory::where('status', '!=', 'draft')
            ->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start)
            ->get(['id', 'title', 'map_data', 'start_date', 'end_date', 'status']);

        return response()->json([
            'reports' => $reports,
            'advisories' => $advisories,
            'start' => $start->toIso8601String(),
            'end' => $end->toIso8601String(),
        ]);
    }
    
}
