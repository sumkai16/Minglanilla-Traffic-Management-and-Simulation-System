<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //

    public function index(){
        $reports = Report::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
          
            $pendingCount = Report::where('user_id', Auth::id())->where('status', 'pending')->count();
            $verifiedCount = Report::where('user_id', Auth::id())->where('status', 'verified')->count();
            $resolvedCount = Report::where('user_id', Auth::id())->where('status', 'resolved')->count();
            
            return view('user.dashboard', compact('reports','pendingCount','verifiedCount','resolvedCount'));
    }
}
