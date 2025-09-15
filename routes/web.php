<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordOtpController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\FestivalCategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\EventHighlightController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Models\FestivalCategory;

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
    Route::get('/sponsors', [\App\Http\Controllers\Admin\SponsorController::class, 'index'])->name('sponsors.index');
    Route::get('/sponsors/create', [\App\Http\Controllers\Admin\SponsorController::class, 'create'])->name('sponsors.create');
    Route::post('/sponsors', [\App\Http\Controllers\Admin\SponsorController::class, 'store'])->name('sponsors.store');
    Route::get('/sponsors/{sponsor}', [\App\Http\Controllers\Admin\SponsorController::class, 'show'])->name('sponsors.show');
    Route::get('/sponsors/{sponsor}/edit', [\App\Http\Controllers\Admin\SponsorController::class, 'edit'])->name('sponsors.edit');
    Route::put('/sponsors/{sponsor}', [\App\Http\Controllers\Admin\SponsorController::class, 'update'])->name('sponsors.update');
    Route::delete('/sponsors/{sponsor}', [\App\Http\Controllers\Admin\SponsorController::class, 'destroy'])->name('sponsors.destroy');
    Route::post('/sponsors/{sponsor}/toggle-status', [\App\Http\Controllers\Admin\SponsorController::class, 'toggleStatus'])->name('sponsors.toggle-status');

    // Media CRUD
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::get('/media/create', [MediaController::class, 'create'])->name('media.create');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::get('/media/{media}/edit', [MediaController::class, 'edit'])->name('media.edit');
    Route::put('/media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::post('/media/{media}/toggle-status', [MediaController::class, 'toggleStatus'])->name('media.toggle-status');

    // Event Highlights CRUD
    Route::get('/event-highlights', [EventHighlightController::class, 'index'])->name('event-highlights.index');
    Route::get('/event-highlights/create', [EventHighlightController::class, 'create'])->name('event-highlights.create');
    Route::post('/event-highlights', [EventHighlightController::class, 'store'])->name('event-highlights.store');
    Route::get('/event-highlights/{eventHighlight}/edit', [EventHighlightController::class, 'edit'])->name('event-highlights.edit');
    Route::put('/event-highlights/{eventHighlight}', [EventHighlightController::class, 'update'])->name('event-highlights.update');
    Route::delete('/event-highlights/{eventHighlight}', [EventHighlightController::class, 'destroy'])->name('event-highlights.destroy');
    Route::post('/event-highlights/{eventHighlight}/toggle-status', [EventHighlightController::class, 'toggleStatus'])->name('event-highlights.toggle-status');

    // Advertisements CRUD
    Route::get('/advertisements', [AdvertisementController::class, 'index'])->name('advertisements.index');
    Route::get('/advertisements/create', [AdvertisementController::class, 'create'])->name('advertisements.create');
    Route::post('/advertisements', [AdvertisementController::class, 'store'])->name('advertisements.store');
    Route::get('/advertisements/{advertisement}/edit', [AdvertisementController::class, 'edit'])->name('advertisements.edit');
    Route::put('/advertisements/{advertisement}', [AdvertisementController::class, 'update'])->name('advertisements.update');
    Route::delete('/advertisements/{advertisement}', [AdvertisementController::class, 'destroy'])->name('advertisements.destroy');
    Route::post('/advertisements/{advertisement}/toggle-status', [AdvertisementController::class, 'toggleStatus'])->name('advertisements.toggle-status');

    // Festival Categories CRUD
    Route::get('/festival-categories', [FestivalCategoryController::class, 'index'])->name('festival-categories.index');
    Route::get('/festival-categories/create', [FestivalCategoryController::class, 'create'])->name('festival-categories.create');
    Route::post('/festival-categories', [FestivalCategoryController::class, 'store'])->name('festival-categories.store');
    Route::get('/festival-categories/{festivalCategory}', [FestivalCategoryController::class, 'show'])->name('festival-categories.show');
    Route::get('/festival-categories/{festivalCategory}/edit', [FestivalCategoryController::class, 'edit'])->name('festival-categories.edit');
    Route::put('/festival-categories/{festivalCategory}', [FestivalCategoryController::class, 'update'])->name('festival-categories.update');
    Route::delete('/festival-categories/{festivalCategory}', [FestivalCategoryController::class, 'destroy'])->name('festival-categories.destroy');
    Route::post('/festival-categories/{festivalCategory}/toggle-status', [FestivalCategoryController::class, 'toggleStatus'])->name('festival-categories.toggle-status');
});

// Frontend TU Honours Routes (renamed path)
Route::get('/tu-honors/{festivalCategory:slug}', [FrontendController::class, 'showFestivalCategory'])->name('festival-categories.show');

// 301 redirect from old path to new TU Honours path
Route::get('/festival-categories/{festivalCategory:slug}', function (FestivalCategory $festivalCategory) {
    return redirect()->route(
        'festival-categories.show',
        ['festivalCategory' => $festivalCategory->slug],
        301
    );
});
