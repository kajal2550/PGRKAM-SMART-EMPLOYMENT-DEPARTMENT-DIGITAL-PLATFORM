<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\JobController;
use App\Http\Controllers\Web\TrainingController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\AdminController;

// ── Public ────────────────────────────────────────────────────────────────────
Route::get('/',          [PageController::class, 'home'])->name('home');
Route::get('/about',     [PageController::class, 'about'])->name('about');
Route::get('/contact',   [PageController::class, 'contact'])->name('contact');

Route::get('/jobs',                       [JobController::class, 'index'])->name('jobs.index');
Route::get('/training',                   [TrainingController::class, 'index'])->name('training.index');
Route::get('/services',                   [ServiceController::class, 'index'])->name('services.index');

// ── Auth ──────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get ('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get ('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated ─────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Jobs
    Route::get ('/jobs/{id}/apply',  [JobController::class, 'showApply'])->name('jobs.apply.show');
    Route::post('/jobs/{id}/apply',  [JobController::class, 'apply'])->name('jobs.apply');
    Route::post('/jobs/{id}/save',   [JobController::class, 'saveToggle'])->name('jobs.save');

    // Training
    Route::get ('/training/{id}/enroll', [TrainingController::class, 'showEnroll'])->name('training.enroll.show');
    Route::post('/training/{id}/enroll', [TrainingController::class, 'enroll'])->name('training.enroll');

    // Profile
    Route::get ('/profile',           [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile',           [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password',  [ProfileController::class, 'changePassword'])->name('profile.password');

    // User pages
    Route::get('/my-applications', [PageController::class, 'applications'])->name('applications');
    Route::get('/my-enrollments',  [PageController::class, 'enrollments'])->name('enrollments');
    Route::get('/saved-jobs',      [PageController::class, 'savedJobs'])->name('saved-jobs');
    Route::get('/notifications',   [PageController::class, 'notifications'])->name('notifications');
    Route::get('/resume',          [PageController::class, 'resume'])->name('resume');
    Route::post('/resume',         [PageController::class, 'saveResume'])->name('resume.save');
    Route::get('/counselling',     [PageController::class, 'counselling'])->name('counselling');
    Route::post('/counselling',    [PageController::class, 'bookCounselling'])->name('counselling.book');
});

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',                    [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users',                        [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{id}',                [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/jobs',                         [AdminController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/create',                  [AdminController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs',                        [AdminController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{id}/edit',               [AdminController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{id}',                    [AdminController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{id}',                 [AdminController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/trainings',                    [AdminController::class, 'trainings'])->name('trainings');
    Route::delete('/trainings/{id}',            [AdminController::class, 'deleteTraining'])->name('trainings.delete');
    Route::get('/counselling',                  [AdminController::class, 'counselling'])->name('counselling');
    Route::post('/counselling/{id}/status',     [AdminController::class, 'updateCounselling'])->name('counselling.status');
    Route::get('/applications',                 [AdminController::class, 'applications'])->name('applications');
    Route::post('/applications/{id}/status',    [AdminController::class, 'updateApplication'])->name('applications.status');
});
