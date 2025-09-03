<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordOtpController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\FrontendController;

$productionFrontPage = app()->environment("production") ? '/utsav' : '/';

// Root route - shows welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Main frontend route - production: /utsav, local: /
Route::get($productionFrontPage, [FrontendController::class, 'home'])->name('home');


// Contact page
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

// Password reset via OTP
Route::post('/password/otp/send', [PasswordOtpController::class, 'sendOtp'])->name('password.otp.send');
Route::get('/password/otp', [PasswordOtpController::class, 'showForm'])->name('password.otp.form');
Route::post('/password/otp/verify', [PasswordOtpController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/password/otp/reset', [PasswordOtpController::class, 'showResetForm'])->name('password.otp.reset.form');
Route::post('/password/otp/reset', [PasswordOtpController::class, 'resetWithOtp'])->name('password.otp.reset');

// Admin routes - Protected with auth and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
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

    // Hero CRUD
    Route::get('/heroes', [HeroController::class, 'index'])->name('heroes.index');
    Route::get('/heroes/create', [HeroController::class, 'create'])->name('heroes.create');
    Route::post('/heroes', [HeroController::class, 'store'])->name('heroes.store');
    Route::get('/heroes/{hero}/edit', [HeroController::class, 'edit'])->name('heroes.edit');
    Route::put('/heroes/{hero}', [HeroController::class, 'update'])->name('heroes.update');
    Route::delete('/heroes/{hero}', [HeroController::class, 'destroy'])->name('heroes.destroy');
    Route::delete('/heroes/{hero}/images/{imageIndex}', [HeroController::class, 'removeImage'])->name('heroes.remove-image');

    // About (dynamic about-us section)
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::get('/about/create', [AboutController::class, 'create'])->name('about.create');
    Route::post('/about', [AboutController::class, 'store'])->name('about.store');
    Route::get('/about/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about/update', [AboutController::class, 'update'])->name('about.update');
    Route::delete('/about/images/{index}', [AboutController::class, 'removeImage'])->name('about.images.remove');
    Route::delete('/about', [AboutController::class, 'destroy'])->name('about.destroy');

    // Sponsors CRUD
    Route::resource('sponsors', \App\Http\Controllers\Admin\SponsorController::class);
    Route::post('/sponsors/{sponsor}/toggle-status', [\App\Http\Controllers\Admin\SponsorController::class, 'toggleStatus'])->name('sponsors.toggle-status');
});
