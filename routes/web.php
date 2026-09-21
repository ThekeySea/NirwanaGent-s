<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\BarberController as AdminBarberController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Public\BarberController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\ServiceController;
use App\Http\Controllers\Public\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/about', [PageController::class, 'about']);
Route::get('/gallery', [PageController::class, 'gallery']);
Route::get('/contact', [PageController::class, 'contact']);
Route::post('/contact', [PageController::class, 'contactStore'])->middleware('throttle:30,1');

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{slug}', [ServiceController::class, 'show']);

Route::get('/barbers', [BarberController::class, 'index']);
Route::get('/barbers/{slug}', [BarberController::class, 'show']);

Route::get('/shop', [ShopController::class, 'index']);
Route::get('/shop/{slug}', [ShopController::class, 'show']);

// Booking (Fase 4). Lihat stepper boleh guest, simpan wajib login.
Route::get('/booking', [BookingController::class, 'index']);
Route::post('/booking/availability', [BookingController::class, 'availability'])->middleware('throttle:60,1');
Route::post('/bookings', [BookingController::class, 'store'])->middleware('auth');
Route::get('/booking/confirmation', [BookingController::class, 'confirmation'])->middleware('auth');

// Commerce (Fase 5). Cart dan checkout wajib login agar terikat ke user.
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/items', [CartController::class, 'store']);
    Route::patch('/cart/items/{id}', [CartController::class, 'update']);
    Route::delete('/cart/items/{id}', [CartController::class, 'destroy']);
    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::get('/checkout/success', [CheckoutController::class, 'success']);
});

// Authentication (Fase 3)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'show']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgot']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendLink']);
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth');

// Customer account, hanya milik sendiri
Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index']);
    Route::get('/account/profile', [AccountController::class, 'profile']);
    Route::patch('/account/profile', [AccountController::class, 'updateProfile']);
    Route::get('/account/appointments', [BookingController::class, 'appointments']);
    Route::patch('/account/appointments/{id}/cancel', [BookingController::class, 'cancel']);
    Route::get('/account/orders', [OrderController::class, 'index']);
    Route::get('/account/orders/{id}', [OrderController::class, 'show']);
});

// Admin ops (Fase 6)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index']);
    Route::get('/services', [AdminServiceController::class, 'index']);
    Route::get('/services/create', [AdminServiceController::class, 'create']);
    Route::post('/services', [AdminServiceController::class, 'store']);
    Route::get('/services/{id}/edit', [AdminServiceController::class, 'edit']);
    Route::patch('/services/{id}', [AdminServiceController::class, 'update']);
    Route::delete('/services/{id}', [AdminServiceController::class, 'destroy']);
    Route::get('/barbers', [AdminBarberController::class, 'index']);
    Route::get('/barbers/create', [AdminBarberController::class, 'create']);
    Route::post('/barbers', [AdminBarberController::class, 'store']);
    Route::get('/barbers/{id}/edit', [AdminBarberController::class, 'edit']);
    Route::patch('/barbers/{id}', [AdminBarberController::class, 'update']);
    Route::delete('/barbers/{id}', [AdminBarberController::class, 'destroy']);
    Route::get('/products', [AdminProductController::class, 'index']);
    Route::get('/products/create', [AdminProductController::class, 'create']);
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit']);
    Route::patch('/products/{id}', [AdminProductController::class, 'update']);
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);
    Route::get('/bookings', [AdminBookingController::class, 'index']);
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show']);
    Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus']);
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
    Route::get('/customers', [AdminCustomerController::class, 'index']);
    Route::get('/customers/{id}', [AdminCustomerController::class, 'show']);
    Route::get('/customers/{id}/edit', [AdminCustomerController::class, 'edit']);
    Route::patch('/customers/{id}', [AdminCustomerController::class, 'update']);
});

Route::get('/design', function () {
    abort_if(app()->isProduction(), 404);

    return view('pages.design');
});
