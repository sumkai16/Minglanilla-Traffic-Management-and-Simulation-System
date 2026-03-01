<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Base query for the authenticated user's reports
        $reportsQuery = $user->reports()->latest();

        // Paginated list of user's reports
        $reports = $reportsQuery->paginate(10);

        // Status counts for the stats cards
        $pendingCount = $user->reports()->where('status', 'pending')->count();
        $verifiedCount = $user->reports()->where('status', 'verified')->count();
        $resolvedCount = $user->reports()->where('status', 'resolved')->count();

        return view('user.dashboard', compact(
            'reports',
            'pendingCount',
            'verifiedCount',
            'resolvedCount'
        ));
    }
}
