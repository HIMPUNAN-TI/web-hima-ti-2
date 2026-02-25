<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/about-us', [LandingPageController::class, 'about'])->name('landing.about.index');
Route::get('/events', [LandingPageController::class, 'events'])->name('landing.events.index');
Route::get('/events/{id}', [LandingPageController::class, 'eventDetail'])->name('landing.events.detail');
Route::get('/contact', [LandingPageController::class, 'contact'])->name('landing.contact.index');
Route::post('/contact', [LandingPageController::class, 'submitContact'])->name('landing.contact.submit');

Route::middleware('role:member')->group(function () {
    Route::get('/events/{id}/register', [LandingPageController::class, 'eventRegister'])->name('landing.events.register');
    Route::post('/events/{id}/register', [LandingPageController::class, 'submitEventRegistration'])->name('landing.events.register');
    Route::get('/my-events', [LandingPageController::class, 'myEvents'])->name('landing.profile.my-events');
});

// Route untuk guest (belum login)
Route::middleware('guest')->group(function () {
    // Member login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Admin login
    Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin area
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

        Route::resource('users', UsersController::class);
        Route::resource('members', MembersController::class);
        Route::resource('events', EventController::class);
        Route::resource('payments', PaymentController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('attendances', AttendanceController::class)->only(['index']);
    });
});


