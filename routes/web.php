<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KandidatsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\LocationsGalleryController;
use App\Http\Controllers\PemilihsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
//     Route::name('dashboard.')->prefix('dashboard')->group(function () {
//         Route::get('/', [DashboardController::class, 'index'])->name('index');
//     });
// });

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::resource('locations', LocationsController::class);
        Route::resource('locations.galleries', LocationsGalleryController::class)->shallow()->only([
            'index', 'create', 'store', 'destroy',
        ]);
        Route::resource('user', UserController::class);
        Route::resource('kandidats', KandidatsController::class);
        Route::resource('pemilihs', PemilihsController::class);
    });
});
