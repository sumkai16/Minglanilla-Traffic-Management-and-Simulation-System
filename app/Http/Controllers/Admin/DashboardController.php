<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $mitcomCount = User::where('role', 'mitcom')->count();
        $userCount = User::where('role', 'user')->count();
        
        // Get all users with latest first
        $users = User::latest()->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'adminCount', 
            'mitcomCount', 
            'userCount',
            'users'
        ));
    }
}