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
        $advisories = TrafficAdvisory::where('created_by', auth()->user()->id)
            ->orderByRaw("FIELD(status, 'published', 'draft', 'archived')")
            ->latest()
            ->get();

        return view('head-mitcom.advisories.index', compact('advisories'));
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
