<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\TrafficAdvisory;
use Illuminate\Http\Request;

class TrafficAdvisoryController extends Controller
{
    //

    public function index()
    {
        $query = TrafficAdvisory::where('created_by', auth()->user()->id);

        // Search by title
        if ($search = request('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        // Filter by status
        if (request('status') && request('status') !== 'all') {
            $query->where('status', request('status'));
        }

        // Sort
        $sortField = request('sort', 'created_at');
        $sortDir = request('dir', 'desc');
        $allowedSorts = ['title', 'created_at', 'start_date', 'status'];
        $allowedDirs = ['asc', 'desc'];

        if (!in_array($sortField, $allowedSorts)) $sortField = 'created_at';
        if (!in_array($sortDir, $allowedDirs)) $sortDir = 'desc';

        // Always keep status priority ordering, then apply user sort
        $query->orderByRaw("FIELD(status, 'published', 'draft', 'archived')")
              ->orderBy($sortField, $sortDir);

        $advisories = $query->paginate(10)->withQueryString();

        // Stats for cards
        $userId = auth()->user()->id;
        $stats = [
            'total'     => TrafficAdvisory::where('created_by', $userId)->count(),
            'published' => TrafficAdvisory::where('created_by', $userId)->where('status', 'published')->count(),
            'draft'     => TrafficAdvisory::where('created_by', $userId)->where('status', 'draft')->count(),
            'archived'  => TrafficAdvisory::where('created_by', $userId)->where('status', 'archived')->count(),
        ];

        return view('head-mitcom.advisories.index', compact('advisories', 'stats'));
    }

    public function create()
    {
        return view('head-mitcom.advisories.create');
    }

    public function store(Request $request)
    {
        //

          $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'map_data'    => ['nullable', 'string'],
        ]);

          TrafficAdvisory::create([
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => 'draft',
            'map_data'    => $request->map_data ? json_decode($request->map_data, true) : null,
            'created_by'  => auth()->user()->id,
        ]);

        return redirect()->route('head-mitcom.advisories.index')
            ->with('success', 'Advisory created successfully.');
    }

    public function show(TrafficAdvisory $advisory)
    {
        //
        return view('head-mitcom.advisories.show', compact('advisory'));
    }

    public function update(Request $request, TrafficAdvisory $advisory)
    {
            $request->validate([
                'title'       => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'start_date'  => ['required', 'date'],
                'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
                'map_data'    => ['nullable', 'string'],
            ]);

            $advisory->update([
                'title'       => $request->title,
                'description' => $request->description,
                'start_date'  => $request->start_date,
                'end_date'    => $request->end_date,
                'map_data'    => $request->map_data ? json_decode($request->map_data, true) : null,
            ]);

            return redirect()->route('head-mitcom.advisories.index')
                ->with('success', 'Advisory updated successfully.');
    }
    public function edit(TrafficAdvisory $advisory)
    {
        return view('head-mitcom.advisories.edit', compact('advisory'));
    }
    public function publish (TrafficAdvisory $advisory)
    {
         $advisory->update(['status' => 'published']);

        return back()->with('success', 'Advisory published.');
    }

    public function unpublish (TrafficAdvisory $advisory)
    {
         $advisory->update(['status' => 'draft']);

        return back()->with('success', 'Advisory unpublished.');
    }

     public function archive (TrafficAdvisory $advisory)
    {
         $advisory->update(['status' => 'archived']);

        return back()->with('success', 'Advisory archived.');
    }

    public function destroy (TrafficAdvisory $advisory)
    {
        $advisory->delete();

        return redirect()->route('head-mitcom.advisories.index')
            ->with('success', 'Advisory deleted successfully.');
    }
}
