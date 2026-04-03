<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('dashboard:admin:user-stats', now()->addSeconds(60), function () {
            return User::query()
                ->selectRaw('COUNT(*) as total_users')
                ->selectRaw("SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admin_count")
                ->selectRaw("SUM(CASE WHEN role = 'head-mitcom' THEN 1 ELSE 0 END) as head_mitcom_count")
                ->selectRaw("SUM(CASE WHEN role = 'enforcer' THEN 1 ELSE 0 END) as enforcer_count")
                ->selectRaw("SUM(CASE WHEN role = 'user' THEN 1 ELSE 0 END) as user_count")
                ->first();
        });

        $totalUsers = (int) ($stats->total_users ?? 0);
        $adminCount = (int) ($stats->admin_count ?? 0);
        $headMitcomCount = (int) ($stats->head_mitcom_count ?? 0);
        $enforcerCount = (int) ($stats->enforcer_count ?? 0);
        $userCount = (int) ($stats->user_count ?? 0);

        return view('admin.dashboard', compact(
            'totalUsers',
            'adminCount',
            'headMitcomCount',
            'enforcerCount',
            'userCount'
        ));
    }
    public function map(){
        return view('admin.map');
    }
}
