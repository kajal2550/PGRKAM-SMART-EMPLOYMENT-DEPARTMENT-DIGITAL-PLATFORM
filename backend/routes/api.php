<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ChatGuideController;
use App\Http\Controllers\Api\CounsellingController;
use App\Http\Controllers\Api\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes return JSON and are prefixed with /api (set in bootstrap/app.php)
|
*/

// ── Public Authentication Routes ─────────────────────────────────────────────
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// ── Public Resource Routes ────────────────────────────────────────────────────
Route::get('/services',        [ServiceController::class, 'index']);
Route::get('/services/{id}',   [ServiceController::class, 'show']);
Route::get('/jobs',            [JobController::class,     'index']);
Route::get('/jobs/{id}',       [JobController::class,     'show']);
Route::get('/training',        [TrainingController::class, 'index']);
Route::get('/training/{id}',   [TrainingController::class, 'show']);

// ── Chat / Smart Guidance (public – no auth required) ────────────────────────
Route::post('/chat-guide',     [ChatGuideController::class, 'handle']);

// ── Authenticated Routes (Laravel Sanctum) ───────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // User profile & preferences
    Route::prefix('user')->group(function () {
        Route::get('/profile',                   [UserController::class, 'profile']);
        Route::put('/profile',                   [UserController::class, 'updateProfile']);
        Route::get('/notifications',             [UserController::class, 'notifications']);
        Route::put('/notifications/{id}/read',   [UserController::class, 'markNotificationRead']);
        Route::get('/saved-jobs',                [UserController::class, 'savedJobs']);
        Route::get('/resume',                    [UserController::class, 'getResume']);
        Route::post('/resume',                   [UserController::class, 'saveResume']);
        Route::get('/counselling',               [UserController::class, 'counsellingSessions']);
    });

    // Jobs – save/apply (requires auth)
    Route::post('/jobs/{id}/save',   [JobController::class, 'saveJob']);
    Route::post('/jobs/{id}/apply',  [JobController::class, 'applyJob']);

    // Training – enrol
    Route::post('/training/{id}/enroll', [TrainingController::class, 'enroll']);

    // Counselling – book session
    Route::post('/counselling',         [CounsellingController::class, 'book']);
    Route::get('/counselling/{id}',     [CounsellingController::class, 'show']);
    Route::delete('/counselling/{id}',  [CounsellingController::class, 'cancel']);

    // ── Admin-only routes ─────────────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard',          [AdminController::class, 'dashboard']);
        Route::get('/users',              [AdminController::class, 'users']);
        Route::delete('/users/{id}',      [AdminController::class, 'deleteUser']);
        Route::get('/reports',            [AdminController::class, 'reports']);

        // Services CRUD
        Route::post('/services',          [ServiceController::class, 'store']);
        Route::put('/services/{id}',      [ServiceController::class, 'update']);
        Route::delete('/services/{id}',   [ServiceController::class, 'destroy']);

        // Jobs CRUD
        Route::post('/jobs',              [JobController::class, 'store']);
        Route::put('/jobs/{id}',          [JobController::class, 'update']);
        Route::delete('/jobs/{id}',       [JobController::class, 'destroy']);

        // Schemes
        Route::get('/schemes',            [AdminController::class, 'schemes']);
        Route::post('/schemes',           [AdminController::class, 'addScheme']);
    });
});
