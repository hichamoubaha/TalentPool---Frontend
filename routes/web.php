<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AnnouncementController;
use App\Http\Controllers\Web\ApplicationController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HomeController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Routes protégées
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes pour les candidats
    Route::middleware('can:candidate')->group(function () {
        Route::get('/my-applications', [ApplicationController::class, 'candidateIndex'])->name('applications.candidate');
        Route::post('/announcements/{announcement}/apply', [ApplicationController::class, 'store'])->name('applications.store');
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    });

    // Routes pour les recruteurs
    Route::middleware('can:recruiter')->group(function () {
        Route::get('/recruiter/announcements', [AnnouncementController::class, 'recruiterIndex'])->name('announcements.recruiter');
        Route::get('/recruiter/applications', [ApplicationController::class, 'recruiterIndex'])->name('applications.recruiter');
        Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
        Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    });

    // Routes pour les administrateurs
    Route::middleware('can:admin')->group(function () {
        Route::get('/admin/statistics', [DashboardController::class, 'adminStatistics'])->name('admin.statistics');
    });
});
