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
    // Mode 2 — no date params, return only active advisories
    if (!$request->filled('start') && !$request->filled('end')) {
        $advisories = TrafficAdvisory::where('status', 'published')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get(['id', 'title', 'map_data', 'start_date', 'end_date', 'status']);

        return response()->json([
            'reports'    => [],
            'advisories' => $advisories,
            'start'      => now()->toIso8601String(),
            'end'        => now()->toIso8601String(),
        ]);
    }

    // Mode 1 — date range provided, return reports + advisories
    $start = Carbon::parse($request->get('start', now()->subDays(30)->startOfDay()));
    $end   = Carbon::parse($request->get('end', now()->endOfDay()));

    $reports = Report::whereBetween('created_at', [$start, $end])
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get(['id', 'issue_type', 'location', 'latitude', 'longitude', 'status', 'created_at', 'verified_at', 'assigned_at', 'resolved_at']);

    $advisories = TrafficAdvisory::where('status', '!=', 'draft')
        ->where('start_date', '<=', $end)
        ->where('end_date', '>=', $start)
        ->get(['id', 'title', 'map_data', 'start_date', 'end_date', 'status']);

    return response()->json([
        'reports'    => $reports,
        'advisories' => $advisories,
        'start'      => $start->toIso8601String(),
        'end'        => $end->toIso8601String(),
    ]);
}
    public function analysis()
{
    $reports = Report::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get(['issue_type', 'status', 'created_at', 'resolved_at', 'assigned_at']);

    // Peak hours (0-23)
    $peakHours = $reports->groupBy(fn($r) => Carbon::parse($r->created_at)->hour)
        ->map->count()
        ->sortKeys();

    $hourLabels = collect(range(0, 23))->map(fn($h) => str_pad($h, 2, '0', STR_PAD_LEFT) . ':00');
    $hourData = collect(range(0, 23))->map(fn($h) => $peakHours->get($h, 0));

    // Peak days
    $peakDays = $reports->groupBy(fn($r) => Carbon::parse($r->created_at)->dayOfWeek)
        ->map->count();

    $dayLabels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $dayData = collect(range(0, 6))->map(fn($d) => $peakDays->get($d, 0));

    // Incident type breakdown
    $typeBreakdown = $reports->groupBy('issue_type')
        ->map->count()
        ->sortDesc();

    // Status funnel
    $statusFunnel = $reports->groupBy('status')
        ->map->count();

    // Summary cards
    $peakHour = $hourData->search($hourData->max());
    $peakDay = $dayData->search($dayData->max());
    $mostCommonType = $typeBreakdown->keys()->first();

    $avgResolution = $reports->filter(fn($r) => $r->resolved_at && $r->created_at)
        ->map(fn($r) => Carbon::parse($r->created_at)->diffInHours(Carbon::parse($r->resolved_at)))
        ->avg();

    return view('head-mitcom.analysis', compact(
        'hourLabels', 'hourData',
        'dayLabels', 'dayData',
        'typeBreakdown', 'statusFunnel',
        'peakHour', 'peakDay',
        'mostCommonType', 'avgResolution',
        'reports'
    ));
}
}
