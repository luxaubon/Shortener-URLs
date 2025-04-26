<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\HomeController;

// Protected routes with rate limiting and validation
Route::group(['middleware' => ['auth', 'throttle:60,1']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('urls.dashboard');

    Route::get('/urls', [UrlController::class, 'index'])->name('urls.index');
    Route::post('/urls', [UrlController::class, 'store'])->middleware('validate.url')->name('urls.store');
    Route::get('/urls/{url}', [UrlController::class, 'show'])->name('urls.show');
    Route::put('/urls/{url}', [UrlController::class, 'update'])->name('urls.update');
    Route::delete('/urls/{url}', [UrlController::class, 'destroy'])->name('urls.destroy');
});

// Public URL shortener route with rate limiting
Route::get('/u/{shortener_url}', [UrlController::class, 'redirect'])
    ->middleware('throttle:30,1')
    ->name('shortener.redirect');