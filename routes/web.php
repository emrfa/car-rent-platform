<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarController as PublicCarController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES (No Login Required) ---
Route::get('/', [PublicCarController::class, 'home'])->name('home');
Route::get('/cars', [PublicCarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [PublicCarController::class, 'show'])->name('cars.show');
Route::view('/services', 'pages.services')->name('services');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/terms-of-service', 'pages.terms')->name('terms');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');
Route::view('/about', 'pages.about')->name('about');

// --- AUTHENTICATED USER ROUTES (Login Required) ---
Route::middleware(['auth', 'verified'])->group(function () { // 'verified' ensures email is verified if using that feature

    // Default User Dashboard (if you keep it)
    Route::get('/dashboard', function () {
      // Check the user's role
    // *** Adjust Auth::user()->role !== 'admin' if your role check is different ***
    if (Auth::check() && Auth::user()->role === 'admin') {
        // If user is an admin, redirect to the admin dashboard
        return redirect()->route('admin.dashboard');
    } else {
        // If user is NOT an admin (or not logged in somehow), redirect to home page
        // Or you could redirect to a user-specific profile page later
        return redirect()->route('home');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking Routes (Require login to initiate or view)
    Route::get('/cars/{car}/book', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/cars/{car}/book', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');

    Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index');

});

// --- ADMIN ROUTES (Login Required + Admin Role) ---
Route::middleware(['auth', 'verified', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    // You'll need to create the 'is.admin' middleware

    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Car Management
    Route::get('/cars', [AdminCarController::class, 'index'])->name('cars.index');
    Route::get('/cars/create', [AdminCarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [AdminCarController::class, 'store'])->name('cars.store');
    Route::get('/cars/{car}/edit', [AdminCarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [AdminCarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [AdminCarController::class, 'destroy'])->name('cars.destroy');
    Route::delete('/cars/images/{image}', [AdminCarController::class, 'destroyImage'])->name('cars.images.destroy');
    Route::patch('/cars/{car}/status/maintenance', [AdminCarController::class, 'updateStatusMaintenance'])->name('cars.status.maintenance');
    Route::patch('/cars/{car}/status/archived', [AdminCarController::class, 'updateStatusArchived'])->name('cars.status.archived');
    Route::patch('/cars/{car}/status/available', [AdminCarController::class, 'updateStatusAvailable'])->name('cars.status.available');

    // Admin Booking Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}/edit', [AdminBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');

});

// --- Authentication Routes ---
require __DIR__.'/auth.php';