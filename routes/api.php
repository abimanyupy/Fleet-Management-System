<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\TruckServiceController;
use App\Http\Controllers\TruckAssignmentsController;
use App\Http\Controllers\HaulingRouteWeatherController;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('drivers', DriversController::class);
Route::resource('trucks', TruckController::class);
Route::resource('truck-service', TruckServiceController::class);
Route::resource('hauling-route-weather', HaulingRouteWeatherController::class);
Route::resource('truck-assignment', TruckAssignmentsController::class);
Route::get('/check-upcoming-service', [TruckServiceController::class, 'checkUpcomingService']);
