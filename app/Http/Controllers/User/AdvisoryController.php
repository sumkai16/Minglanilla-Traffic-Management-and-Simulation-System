<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrafficAdvisory;
use Illuminate\View\View;

class AdvisoryController extends Controller
{
    public function show(TrafficAdvisory $advisory): View
    {
        if ($advisory->status !== 'published') {
            abort(404);
        }

        $advisory->load('creator');

        return view('user.advisories.show', compact('advisory'));
    }
}