<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/quiz-recommendation', [HomeController::class, 'quizRecommendation'])->name('quiz.recommendation');

// Catalog Routes
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/catalog/{id}/check-availability', [CatalogController::class, 'checkAvailability'])->name('catalog.check-availability');
Route::post('/catalog/{id}/wishlist', [CatalogController::class, 'toggleWishlist'])->name('catalog.wishlist');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/demo-login/{role}', [AuthController::class, 'quickDemoLogin'])->name('demo.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer Authenticated Routes
Route::middleware('auth')->group(function () {
    // Checkout & Rental Process
    Route::get('/checkout/{id}', [RentalController::class, 'checkout'])->name('rental.checkout');
    Route::post('/rental/store', [RentalController::class, 'store'])->name('rental.store');
    Route::get('/rental/payment/{rentalCode}', [RentalController::class, 'payment'])->name('rental.payment');
    Route::post('/rental/payment/{rentalCode}', [RentalController::class, 'processPayment'])->name('rental.process-payment');
    Route::get('/rental/invoice/{rentalCode}', [RentalController::class, 'invoice'])->name('rental.invoice');

    // Customer Portal Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-rentals', [UserDashboardController::class, 'rentals'])->name('user.rentals');
    Route::get('/my-wishlists', [UserDashboardController::class, 'wishlists'])->name('user.wishlists');
    Route::post('/user/review', [UserDashboardController::class, 'storeReview'])->name('user.review.store');
    Route::post('/user/profile', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
});

// Admin Middleware / Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manage Rentals
    Route::get('/rentals', [AdminController::class, 'rentals'])->name('rentals.index');
    Route::post('/rentals/{id}/status', [AdminController::class, 'updateRentalStatus'])->name('rentals.update-status');

    // Manage Dresses (CRUD)
    Route::get('/dresses', [AdminController::class, 'dresses'])->name('dresses.index');
    Route::get('/dresses/create', [AdminController::class, 'createDress'])->name('dresses.create');
    Route::post('/dresses', [AdminController::class, 'storeDress'])->name('dresses.store');
    Route::get('/dresses/{id}/edit', [AdminController::class, 'editDress'])->name('dresses.edit');
    Route::put('/dresses/{id}', [AdminController::class, 'updateDress'])->name('dresses.update');
    Route::delete('/dresses/{id}', [AdminController::class, 'destroy'])->name('dresses.destroy');

    // Manage Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');

    // Manage Users
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');

    // Reports & Export (PDF / Excel / CSV)
    Route::get('/reports/rentals', [AdminController::class, 'rentalReport'])->name('reports.rentals');
    Route::get('/reports/rentals/export', [AdminController::class, 'exportRentalsCsv'])->name('reports.rentals.export');
});
