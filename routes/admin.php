<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UrlController as AdminUrlController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['web', 'guest', 'throttle:5,1'])->group(function () {
    Route::get('/admin', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'store'])->name('admin.login.submit');
});

Route::post('/admin/logout', [LoginController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('admin.logout');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['admin'],
    'as' => 'admin.'
], function() {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Users 
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Admin URLs 
    Route::get('/urls', [AdminUrlController::class, 'index'])->name('urls.index');
    Route::post('/urls', [AdminUrlController::class, 'store'])->name('urls.store');
    Route::get('/urls/{url}', [AdminUrlController::class, 'show'])->name('urls.show');
    Route::put('/urls/{url}', [AdminUrlController::class, 'update'])->name('urls.update');
    Route::delete('/urls/{url}', [AdminUrlController::class, 'destroy'])->name('urls.destroy');
});