<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers      = User::count();
        $adminCount      = User::where('role', 'admin')->count();
        $headMitcomCount = User::where('role', 'head-mitcom')->count();
        $enforcerCount   = User::where('role', 'enforcer')->count();
        $userCount       = User::where('role', 'user')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'adminCount',
            'headMitcomCount',
            'enforcerCount',
            'userCount'
        ));
    }
}