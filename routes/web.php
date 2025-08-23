<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordOtpController;

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
