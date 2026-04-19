<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdvisoryController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UsermanagementController as AdminUserController;
use App\Http\Controllers\Admin\ReportManagementController as AdminReportController;

use App\Http\Controllers\Enforcer\DashboardController as EnforcerDashboardController;
use App\Http\Controllers\Enforcer\ReportController as EnforcerReportController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\User\AnnouncementController as UserAnnouncementController;
use App\Http\Controllers\User\AdvisoryController as UserAdvisoryController;

use App\Http\Controllers\HeadMitcom\DashboardController as HeadMitcomDashboardController;
use App\Http\Controllers\HeadMitcom\ReportController as HeadMitcomReportController;
use App\Http\Controllers\HeadMitcom\EnforcerController as HeadMitcomEnforcerController;
use App\Http\Controllers\HeadMitcom\AnnouncementController as HeadMitcomAnnouncementController;
use App\Http\Controllers\HeadMitcom\TrafficAdvisoryController as HeadMitcomAdvisoryController;
use App\Http\Controllers\HeadMitcom\SimulationController as HeadMitcomSimulationController;
use App\Http\Controllers\HeadMitcom\EnforcerStationController as HeadMitcomEnforcerStationController;

// ─────────────────────────────────────────────
// Public Routes
// ─────────────────────────────────────────────

Route::get('/', function () {
    $reportCount = \App\Models\Report::count();
    return view('welcome', compact('reportCount'));
});

Route::get('/report', [ReportController::class, 'create'])->name('report.create');
Route::post('/report', [ReportController::class, 'store'])->name('report.store');
Route::post('/reports/check-duplicate', [ReportController::class, 'checkDuplicate'])->name('reports.check-duplicate');
Route::get('/api/reports/map', [ReportController::class, 'mapData'])->name('reports.map');

Route::get('/advisories', [AdvisoryController::class, 'index'])->name('advisories.index');
Route::get('/advisories/{advisory}', [AdvisoryController::class, 'show'])->name('advisories.show');

// ─────────────────────────────────────────────
// Authenticated — All Roles
// ─────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        /** @var User $user */
        $user = Auth::user();

        return match(true) {
            $user->isAdmin()      => redirect()->route('admin.dashboard'),
            $user->isEnforcer()   => redirect()->route('enforcer.dashboard'),
            $user->isHeadMitcom() => redirect()->route('head-mitcom.dashboard'),
            default               => redirect()->route('user.dashboard'),
        };
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

// ─────────────────────────────────────────────
// Admin Routes
// ─────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/map', [AdminDashboardController::class, 'map'])->name('map');
    Route::get('/system', [AdminDashboardController::class, 'system'])->name('system');
    Route::get('/audit-log', [AdminDashboardController::class, 'auditLog'])->name('audit-log');

    Route::resource('users', AdminUserController::class);

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::patch('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.updateStatus');
});

// ─────────────────────────────────────────────
// Enforcer Routes
// ─────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:enforcer'])
    ->prefix('enforcer')
    ->name('enforcer.')
    ->group(function () {

    Route::get('/dashboard', [EnforcerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/reports', [EnforcerReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [EnforcerReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/proof', [EnforcerReportController::class, 'submitProof'])->name('reports.proof');
});

// ─────────────────────────────────────────────
// Citizen (User) Routes
// ─────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', fn () => redirect()->route('profile.edit'))->name('profile.edit');

    Route::get('/announcements', [UserAnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{announcement}', [UserAnnouncementController::class, 'show'])->name('announcements.show');
    Route::get('/advisories/{advisory}', [UserAdvisoryController::class, 'show'])->name('advisories.show');

    Route::get('/reports/create', [UserReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [UserReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [UserReportController::class, 'show'])->name('reports.show');
});

// ─────────────────────────────────────────────
// Head MITCOM Routes
// ─────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:head-mitcom'])
    ->prefix('head-mitcom')
    ->name('head-mitcom.')
    ->group(function () {

    Route::get('/dashboard', [HeadMitcomDashboardController::class, 'index'])->name('dashboard');
    Route::get('/map', [HeadMitcomDashboardController::class, 'map'])->name('map');

    // Reports
    Route::get('/reports', [HeadMitcomReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [HeadMitcomReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [HeadMitcomReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [HeadMitcomReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/assign', [HeadMitcomReportController::class, 'assign'])->name('reports.assign');
    Route::post('/reports/{report}/reassign', [HeadMitcomReportController::class, 'reassign'])->name('reports.reassign');
    Route::post('/reports/{report}/verify', [HeadMitcomReportController::class, 'verify'])->name('reports.verify');
    Route::post('/reports/{report}/reject', [HeadMitcomReportController::class, 'reject'])->name('reports.reject');
    Route::post('/reports/{report}/confirm-resolved', [HeadMitcomReportController::class, 'confirmResolved'])->name('reports.confirm-resolved');
    Route::post('/reports/{report}/reject-resolved', [HeadMitcomReportController::class, 'rejectResolved'])->name('reports.reject-resolved');

    // Enforcers
    Route::get('/enforcers', [HeadMitcomEnforcerController::class, 'index'])->name('enforcers.index');
    Route::get('/enforcers/{user}', [HeadMitcomEnforcerController::class, 'show'])->name('enforcers.show');

    // Enforcer Stations
    Route::resource('enforcer-stations', HeadMitcomEnforcerStationController::class);

    // Announcements
    Route::get('/announcements', [HeadMitcomAnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [HeadMitcomAnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [HeadMitcomAnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [HeadMitcomAnnouncementController::class, 'update'])->name('announcements.update');
    Route::patch('/announcements/{announcement}/publish', [HeadMitcomAnnouncementController::class, 'publish'])->name('announcements.publish');
    Route::patch('/announcements/{announcement}/unpublish', [HeadMitcomAnnouncementController::class, 'unpublish'])->name('announcements.unpublish');

    // Traffic Advisories
    Route::get('/advisories', [HeadMitcomAdvisoryController::class, 'index'])->name('advisories.index');
    Route::get('/advisories/create', [HeadMitcomAdvisoryController::class, 'create'])->name('advisories.create');
    Route::post('/advisories', [HeadMitcomAdvisoryController::class, 'store'])->name('advisories.store');
    Route::get('/advisories/{advisory}', [HeadMitcomAdvisoryController::class, 'show'])->name('advisories.show');
    Route::get('/advisories/{advisory}/edit', [HeadMitcomAdvisoryController::class, 'edit'])->name('advisories.edit');
    Route::put('/advisories/{advisory}', [HeadMitcomAdvisoryController::class, 'update'])->name('advisories.update');
    Route::post('/advisories/{advisory}/publish', [HeadMitcomAdvisoryController::class, 'publish'])->name('advisories.publish');
    Route::post('/advisories/{advisory}/unpublish', [HeadMitcomAdvisoryController::class, 'unpublish'])->name('advisories.unpublish');
    Route::post('/advisories/{advisory}/archive', [HeadMitcomAdvisoryController::class, 'archive'])->name('advisories.archive');
    Route::delete('/advisories/{advisory}', [HeadMitcomAdvisoryController::class, 'destroy'])->name('advisories.destroy');

    // Simulation
    Route::get('/simulation', [HeadMitcomSimulationController::class, 'index'])->name('simulation.index');
    Route::get('/simulation/data', [HeadMitcomSimulationController::class, 'data'])->name('simulation.data');
    Route::get('/analysis', [HeadMitcomSimulationController::class, 'analysis'])->name('analysis');
});

require __DIR__.'/auth.php';