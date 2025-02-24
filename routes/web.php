<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GpsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\FuelLogController;
use App\Http\Controllers\TruckServiceController;
use App\Http\Controllers\HaulingRoutesController;
use App\Http\Controllers\TruckConditionController;
use App\Http\Controllers\TruckAssignmentsController;
use App\Http\Controllers\HaulingRouteWeatherController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('dashboard');


// Login logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Dashboard (Hanya untuk admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::group([ 'middleware' => ['auth']], function () {
    Route::resource('drivers', DriversController::class);
    Route::resource('trucks', TruckController::class);
    Route::resource('truck-service', TruckServiceController::class);
    Route::resource('truck-condition', TruckConditionController::class);
    Route::resource('fuel-logs', FuelLogController::class);
    Route::resource('gps', GpsController::class);
    Route::resource('truck-assignment', TruckAssignmentsController::class);
    Route::resource('hauling-route', HaulingRoutesController::class);
    Route::resource('hauling-route-weather', HaulingRouteWeatherController::class);
});
