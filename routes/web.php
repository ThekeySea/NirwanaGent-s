<?php

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
Route::post('/contact', [PageController::class, 'contactStore']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{slug}', [ServiceController::class, 'show']);

Route::get('/barbers', [BarberController::class, 'index']);
Route::get('/barbers/{slug}', [BarberController::class, 'show']);

Route::get('/shop', [ShopController::class, 'index']);
Route::get('/shop/{slug}', [ShopController::class, 'show']);

// Placeholder transaksional sampai Fase 4 dan 5. Arahkan ke halaman yang menjelaskan status.
Route::get('/booking', fn () => response()->view('pages.placeholder', [
    'title' => 'Booking segera hadir (Fase 4)',
    'message' => 'Alur booking Service, Barber, Date, Time, Details, Review sedang dibangun. Untuk sekarang, jelajahi layanan dan barber.',
]));
Route::get('/cart', fn () => response()->view('pages.placeholder', [
    'title' => 'Cart segera hadir (Fase 5)',
    'message' => 'Keranjang dan checkout sedang dibangun. Untuk sekarang, jelajahi katalog shop.',
]));

Route::get('/design', function () {
    abort_if(app()->isProduction(), 404);

    return view('pages.design');
});
