<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Enforcer\DashboardController as EnforcerDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\HeadMitcom\DashboardController as HeadMitcomDashboardController;
use App\Http\Controllers\HeadMitcom\ReportController as HeadMitcomReportController;
use App\Http\Controllers\HeadMitcom\EnforcerController as HeadMitcomEnforcerController;
use App\Http\Controllers\HeadMitcom\AnnouncementController as HeadMitcomAnnouncementController;
use App\Http\Controllers\User\AnnouncementController as UserAnnouncementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\NotificationController;
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

      // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
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

    // Report routes
    Route::get('/reports', [App\Http\Controllers\Enforcer\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [App\Http\Controllers\Enforcer\ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/proof', [App\Http\Controllers\Enforcer\ReportController::class, 'submitProof'])->name('reports.proof');
});

// User routes
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/announcements', [UserAnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/reports/create', [App\Http\Controllers\User\ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [App\Http\Controllers\User\ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}',[App\Http\Controllers\User\ReportController::class, 'show'])->name('reports.show');

    Route::get('/profile', fn () => redirect()->route('profile.edit'))->name('profile.edit');
});
// Head MITCOM routes
Route::middleware(['auth', 'verified', 'role:head-mitcom'])->prefix('head-mitcom')->name('head-mitcom.')->group(function () {
    Route::get('/dashboard', [HeadMitcomDashboardController::class, 'index'])->name('dashboard');
    Route::get('/map', [HeadMitcomDashboardController::class, 'map'])->name('map');
    Route::get('/announcements', [HeadMitcomAnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [HeadMitcomAnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [HeadMitcomAnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [HeadMitcomAnnouncementController::class, 'update'])->name('announcements.update');
    Route::patch('/announcements/{announcement}/publish', [HeadMitcomAnnouncementController::class, 'publish'])->name('announcements.publish');
    Route::patch('/announcements/{announcement}/unpublish', [HeadMitcomAnnouncementController::class, 'unpublish'])->name('announcements.unpublish');
    Route::get('/reports', [HeadMitcomReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [HeadMitcomReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/assign', [HeadMitcomReportController::class, 'assign'])->name('reports.assign');
    Route::post('/reports/{report}/reassign', [HeadMitcomReportController::class, 'reassign'])->name('reports.reassign');
    Route::post('/reports/{report}/verify', [HeadMitcomReportController::class, 'verify'])->name('reports.verify');
    Route::post('/reports/{report}/reject', [HeadMitcomReportController::class, 'reject'])->name('reports.reject');

    Route::get('/enforcers', [HeadMitcomEnforcerController::class, 'index'])->name('enforcers.index');
    Route::get('/enforcers/{user}', [HeadMitcomEnforcerController::class, 'show'])->name('enforcers.show');

    Route::post('/reports/{report}/confirm-resolved', [HeadMitcomReportController::class, 'confirmResolved'])->name('reports.confirm-resolved');
    Route::post('/reports/{report}/reject-resolved', [HeadMitcomReportController::class, 'rejectResolved'])->name('reports.reject-resolved');

    //Traffic Advisory routes
    Route::get('/advisories', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'index'])->name('advisories.index');
    Route::get('/advisories/create', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'create'])->name('advisories.create');
    Route::post('/advisories', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'store'])->name('advisories.store');
    Route::get('/advisories/{advisory}', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'show'])->name('advisories.show');
    Route::get('/advisories/{advisory}/edit', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'edit'])->name('advisories.edit');
    Route::put('/advisories/{advisory}', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'update'])->name('advisories.update');
    Route::post('/advisories/{advisory}/publish', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'publish'])->name('advisories.publish');
    Route::post('/advisories/{advisory}/unpublish', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'unpublish'])->name('advisories.unpublish');
    Route::post('/advisories/{advisory}/archive', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'archive'])->name('advisories.archive');
    Route::delete('/advisories/{advisory}', [App\Http\Controllers\HeadMitcom\TrafficAdvisoryController::class, 'destroy'])->name('advisories.destroy');

    //simulation
    Route::get('/simulation', [App\Http\Controllers\HeadMitcom\SimulationController::class, 'index'])->name('simulation.index');
    Route::get('/simulation/data', [App\Http\Controllers\HeadMitcom\SimulationController::class, 'data'])->name('simulation.data');
});

// Public report routes
Route::get('/report', [App\Http\Controllers\ReportController::class, 'create'])->name('report.create');
Route::post('/report', [App\Http\Controllers\ReportController::class, 'store'])->name('report.store');

//public advisory routes
Route::get('/advisories', [\App\Http\Controllers\AdvisoryController::class, 'index'])->name('advisories.index');
Route::get('/advisories/{advisory}', [\App\Http\Controllers\AdvisoryController::class, 'show'])->name('advisories.show');

//API endpoint for map data
Route::get('/api/reports/map', [App\Http\Controllers\ReportController::class, 'mapData'])->name('reports.map');

require __DIR__.'/auth.php';
