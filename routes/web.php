<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Home route for authenticated users
Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth'])
    ->name('home');

// Include route files
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/url.php';
