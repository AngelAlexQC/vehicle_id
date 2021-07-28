<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\DriversController;
use App\Http\Controllers\Api\VehiclesController;
use App\Http\Controllers\Api\ParkingsController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UsersRecordsController;
use App\Http\Controllers\Api\DriversRecordsController;
use App\Http\Controllers\Api\DriversVehiclesController;
use App\Http\Controllers\Api\VehiclesRecordsController;
use App\Http\Controllers\Api\ParkingsRecordsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');
// Driver by DNI
Route::get('drivers/find/{dni}', [
    DriversController::class,
    'findByDNI',
])->name('drivers.vehicles.find');
Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('drivers', DriversController::class);



        // Driver Vehicles
        Route::get('/drivers/{driver}/vehicles', [
            DriversVehiclesController::class,
            'index',
        ])->name('drivers.vehicles.index');
        Route::post('/drivers/{driver}/vehicles', [
            DriversVehiclesController::class,
            'store',
        ])->name('drivers.vehicles.store');

        // Driver Records
        Route::get('/drivers/{driver}/records', [
            DriversRecordsController::class,
            'index',
        ])->name('drivers.records.index');
        Route::post('/drivers/{driver}/records', [
            DriversRecordsController::class,
            'store',
        ])->name('drivers.records.store');

        Route::apiResource('users', UsersController::class);

        // User Records
        Route::get('/users/{user}/records', [
            UsersRecordsController::class,
            'index',
        ])->name('users.records.index');
        Route::post('/users/{user}/records', [
            UsersRecordsController::class,
            'store',
        ])->name('users.records.store');

        Route::apiResource('vehicles', VehiclesController::class);

        // Vehicle Records
        Route::get('/vehicles/{vehicle}/records', [
            VehiclesRecordsController::class,
            'index',
        ])->name('vehicles.records.index');
        Route::post('/vehicles/{vehicle}/records', [
            VehiclesRecordsController::class,
            'store',
        ])->name('vehicles.records.store');

        Route::apiResource('parkings', ParkingsController::class);

        // Parking Records
        Route::get('/parkings/{parking}/records', [
            ParkingsRecordsController::class,
            'index',
        ])->name('parkings.records.index');
        Route::post('/parkings/{parking}/records', [
            ParkingsRecordsController::class,
            'store',
        ])->name('parkings.records.store');
    });
