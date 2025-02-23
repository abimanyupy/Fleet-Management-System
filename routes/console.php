<?php

use Carbon\Carbon;
use App\Models\Trucks;
use App\Models\TruckService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\TruckServiceController;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Schedule::call(function () {
    app(TruckServiceController::class)->checkUpcomingService();
})->everyMinute();
