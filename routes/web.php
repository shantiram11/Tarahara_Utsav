<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordOtpController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;

Route::get('/', function () {
    return view('frontend.index');
})->name('home');

// Contact page
Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

// Password reset via OTP
Route::post('/password/otp/send', [PasswordOtpController::class, 'sendOtp'])->name('password.otp.send');
Route::get('/password/otp', [PasswordOtpController::class, 'showForm'])->name('password.otp.form');
Route::post('/password/otp/verify', [PasswordOtpController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/password/otp/reset', [PasswordOtpController::class, 'showResetForm'])->name('password.otp.reset.form');
Route::post('/password/otp/reset', [PasswordOtpController::class, 'resetWithOtp'])->name('password.otp.reset');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile & Password
    Route::get('/profile', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Users CRUD
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
