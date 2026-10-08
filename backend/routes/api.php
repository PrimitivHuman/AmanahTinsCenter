<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
// Authentication
Route::post('/auth/login', [AuthController::class, 'login']);

// Articles (Public)
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);

// Team (Public)
Route::get('/team', [TeamController::class, 'index']);

// Appointments / Schedule (Public submission)
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::post('/registrations', [AppointmentController::class, 'store']);

// Clinic Settings (Public)
Route::get('/settings', [SettingController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected Admin Routes (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // Current user & Logout
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Admin Dashboard Stats
    Route::get('/admin/stats', [DashboardController::class, 'stats']);

    // Admin Articles CRUD
    Route::get('/admin/articles', [ArticleController::class, 'adminIndex']);
    Route::get('/admin/articles/{id}', [ArticleController::class, 'adminShow']);
    Route::post('/admin/articles', [ArticleController::class, 'store']);
    Route::put('/admin/articles/{id}', [ArticleController::class, 'update']);
    Route::delete('/admin/articles/{id}', [ArticleController::class, 'destroy']);

    // Admin Team CRUD
    Route::get('/admin/team', [TeamController::class, 'adminIndex']);
    Route::post('/admin/team', [TeamController::class, 'store']);
    Route::put('/admin/team/{id}', [TeamController::class, 'update']);
    Route::delete('/admin/team/{id}', [TeamController::class, 'destroy']);

    // Admin Appointments / Schedules
    Route::get('/admin/appointments', [AppointmentController::class, 'index']);
    Route::put('/admin/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/admin/appointments/{id}', [AppointmentController::class, 'destroy']);

    // Admin Clinic Settings
    Route::put('/admin/settings', [SettingController::class, 'update']);
});
