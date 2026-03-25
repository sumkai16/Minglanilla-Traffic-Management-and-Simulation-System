<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Enforcer\DashboardController as EnforcerDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\HeadMitcom\DashboardController as HeadMitcomDashboardController;
use App\Http\Controllers\HeadMitcom\ReportController as HeadMitcomReportController;
use App\Http\Controllers\HeadMitcom\EnforcerController as HeadMitcomEnforcerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect based on role
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    /** @var User $user */
    $user = Auth::user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->isEnforcer()) {
        return redirect()->route('enforcer.dashboard');
    }
    
    if ($user->isHeadMitcom()) {
        return redirect()->route('head-mitcom.dashboard');
    }

    return redirect()->route('user.dashboard');
})->name('dashboard');

// Profile routes (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UsermanagementController::class);

    Route::get('reports',[App\Http\Controllers\Admin\ReportManagementController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}',[App\Http\Controllers\Admin\ReportManagementController::class, 'show'])->name('reports.show');
    Route::patch('reports/{report}/status',[App\Http\Controllers\Admin\ReportManagementController::class, 'updateStatus'])->name('reports.updateStatus');

    Route::get('/map', [\App\Http\Controllers\Admin\DashboardController::class, 'map'])->name('map');
});

// Enforcer routes
Route::middleware(['auth', 'verified', 'role:enforcer'])->prefix('enforcer')->name('enforcer.')->group(function () {
    Route::get('/dashboard', [EnforcerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports/{report}', [App\Http\Controllers\Enforcer\ReportController::class, 'show'])->name('reports.show');
});

// User routes
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports/create', [App\Http\Controllers\User\ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [App\Http\Controllers\User\ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}',[App\Http\Controllers\User\ReportController::class, 'show'])->name('reports.show');

    Route::get('/profile', fn () => redirect()->route('profile.edit'))->name('profile.edit');
});
// Head MITCOM routes
Route::middleware(['auth', 'verified', 'role:head-mitcom'])->prefix('head-mitcom')->name('head-mitcom.')->group(function () {
    Route::get('/dashboard', [HeadMitcomDashboardController::class, 'index'])->name('dashboard');
    Route::get('/map', [HeadMitcomDashboardController::class, 'map'])->name('map');
    Route::get('/reports', [HeadMitcomReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [HeadMitcomReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/assign', [HeadMitcomReportController::class, 'assign'])->name('reports.assign');
    Route::post('/reports/{report}/reassign', [HeadMitcomReportController::class, 'reassign'])->name('reports.reassign');
    Route::post('/reports/{report}/verify', [HeadMitcomReportController::class, 'verify'])->name('reports.verify');
    Route::post('/reports/{report}/reject', [HeadMitcomReportController::class, 'reject'])->name('reports.reject');

    Route::get('/enforcers', [HeadMitcomEnforcerController::class, 'index'])->name('enforcers.index');
    Route::get('/enforcers/{user}', [HeadMitcomEnforcerController::class, 'show'])->name('enforcers.show');
});

// Public report routes
Route::get('/report', [App\Http\Controllers\ReportController::class, 'create'])->name('report.create');
Route::post('/report', [App\Http\Controllers\ReportController::class, 'store'])->name('report.store');


//API endpoint for map data
Route::get('/api/reports/map', [App\Http\Controllers\ReportController::class, 'mapData'])->name('reports.map');

require __DIR__.'/auth.php';
