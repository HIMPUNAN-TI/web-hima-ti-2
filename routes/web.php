<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Landing Pages
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/about-us', [LandingPageController::class, 'about'])->name('landing.about.index');
Route::get('/events', [LandingPageController::class, 'events'])->name('landing.events.index');
Route::get('/events/{id}', [LandingPageController::class, 'eventDetail'])->name('landing.events.detail');
Route::get('/contact', [LandingPageController::class, 'contact'])->name('landing.contact.index');
Route::post('/contact', [LandingPageController::class, 'submitContact'])->name('landing.contact.submit');

// Guest Only Routes
Route::middleware('guest')->group(function () {
    // Member login & register
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Admin login
    Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);

    // OAuth (Google & Microsoft)
    Route::get('/auth/{provider}', [AuthController::class, 'redirectToProvider'])->name('oauth.redirect');
    Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback'])->name('oauth.callback');

    // Forgot & Reset Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Tautan verifikasi email dari Gmail/Inbox (dapat diakses langsung tanpa harus login sebelumnya)
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    // Pastikan hash email sesuai dengan sha1(email)
    if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
        return redirect()->route('login')->with('error', 'Tautan verifikasi email tidak valid.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));

        // Kirim email konfirmasi resmi bahwa akun & email sudah terverifikasi
        try {
            \Illuminate\Support\Facades\Mail::to($user)->send(
                new \App\Mail\EmailVerifiedNotification($user)
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal kirim email konfirmasi verifikasi: ' . $e->getMessage());
        }
    }

    // Login-kan user secara otomatis di sesi browser ini
    \Illuminate\Support\Facades\Auth::login($user);

    return redirect()->route('landing.profile.edit')->with('success', 'Email Anda berhasil diverifikasi! Silakan lengkapi profil Anda.');
})->middleware(['signed'])->name('verification.verify');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification Notice & Resend Handlers
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Tautan verifikasi baru telah dikirim ke email Anda!');
    })->middleware(['throttle:6,1'])->name('verification.send');

    // Member Routes (Wajib Verified & Role Member)
    Route::middleware(['role:member', 'verified'])->group(function () {
        // Kelengkapan Data Profil Peserta (Requirement 2)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('landing.profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('landing.profile.update');

        Route::get('/events/{id}/register', [LandingPageController::class, 'eventRegister'])->name('landing.events.register');
        Route::post('/events/{id}/register', [LandingPageController::class, 'submitEventRegistration'])->name('landing.events.register.submit');
        Route::get('/my-events', [LandingPageController::class, 'myEvents'])->name('landing.profile.my-events');
    });

    // Admin Area
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

        Route::resource('users', UsersController::class);
        Route::resource('members', MembersController::class);
        Route::resource('events', EventController::class);
        Route::resource('payments', PaymentController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('attendances', AttendanceController::class)->only(['index']);
    });
});
