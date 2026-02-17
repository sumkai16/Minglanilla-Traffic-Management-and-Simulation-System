<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Enforcer\DashboardController as EnforcerDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\HeadMitcom\DashboardController as HeadMitcomDasboardController;
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

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// Enforcer routes
Route::middleware(['auth', 'verified', 'role:enforcer'])->prefix('enforcer')->name('enforcer.')->group(function () {
    Route::get('/dashboard', [EnforcerDashboardController::class, 'index'])->name('dashboard');
});

// User routes
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});
// Head MITCOM routes
Route::middleware(['auth', 'verified', 'role:head-mitcom'])->prefix('head-mitcom')->name('head-mitcom.')->group(function () {
    Route::get('/dashboard', [HeadMitcomDasboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
