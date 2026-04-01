<?php

namespace App\Http\Controllers;

use App\Models\TrafficAdvisory;
use Illuminate\Http\Request;

class AdvisoryController extends Controller
{
    public function index()
    {
        $advisories = TrafficAdvisory::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('advisories.index', compact('advisories'));
    }

    public function show(TrafficAdvisory $advisory)
    {
        if ($advisory->status !== 'published') {
            abort(404);
        }

        return view('advisories.show', compact('advisory'));
    }
}