<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\ParkingsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RecordsController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('drivers', DriversController::class);
        // Driver by DNI
        Route::post('drivers/find', [
            DriversController::class,
            'findByDNI',
        ])->name('drivers.vehicles.find');
        Route::resource('users', UsersController::class);
        Route::resource('vehicles', VehiclesController::class);
        Route::resource('parkings', ParkingsController::class);
        Route::resource('records', RecordsController::class);
    });
