<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// Rutas login Google
Route::get('/auth/google/redirect', [GoogleController::class, 'driverRedirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'driverCallback']);

// Rutas login Facebook
Route::get('/auth/facebook/redirect', [FacebookController::class, 'driverRedirect']);
Route::get('/auth/facebook/callback', [FacebookController::class, 'driverCallback']);

// // Rutas login Twitter
// Route::get('/auth/twitter/redirect', [TwitterController::class, 'twitterRedirect']);
// Route::get('/auth/twitter/callback', [TwitterController::class, 'twitterCallback']);