<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CitizenReportController;
use App\Http\Controllers\Api\AdvisoryController;
use App\Http\Controllers\Api\EnforcerReportController;


Route::get('/debug-enforcer', function (Request $request) {
    return response()->json([
        'authenticated' => auth('sanctum')->check(),
        'user' => auth('sanctum')->user()?->only('id', 'email', 'role'),
        'headers' => $request->headers->all(),
    ]);
});
// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    Route::get('/advisories', [AdvisoryController::class, 'index']);
    Route::get('/map/reports', [CitizenReportController::class, 'mapPins']);

    // Citizen routes
    Route::get('/reports', [CitizenReportController::class, 'index']);
    Route::post('/reports', [CitizenReportController::class, 'store']);
    Route::get('/reports/{id}', [CitizenReportController::class, 'show']);

    // Enforcer routes
    Route::get('/enforcer/reports', [EnforcerReportController::class, 'index']);
    Route::put('/enforcer/reports/{id}/status', [EnforcerReportController::class, 'updateStatus']);
    Route::post('/enforcer/reports/{id}/remarks', [EnforcerReportController::class, 'addRemarks']);
});