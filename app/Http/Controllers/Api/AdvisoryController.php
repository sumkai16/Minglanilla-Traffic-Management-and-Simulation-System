<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrafficAdvisory;

class AdvisoryController extends Controller
{
    public function index()
    {
        $advisories = TrafficAdvisory::where('status', 'published')
    ->where(function ($query) {
        $query->whereNull('expires_at')
            ->orWhere('expires_at', '>', now());
    })
    ->orderBy('created_at', 'desc')
    ->get();

        return response()->json($advisories);
    }
}