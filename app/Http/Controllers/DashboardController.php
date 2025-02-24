<?php

namespace App\Http\Controllers;

use App\Models\Gps;
use App\Models\Trucks;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $apiKey = env('WEATHERAPI_KEY');
        $totalTrucks = Trucks::count();
        $totalGpsDevices = Gps::count();

        // Ambil data cuaca untuk lokasi tertentu (contoh: Jakarta)
        $weatherData = Http::get('https://api.weatherapi.com/v1/current.json', [
            'key' => '$apiKey',
            'q' => '-6.1754,106.8272', // Koordinat Jakarta
        ])->json();


        return view('dashboard', [
            'totalTrucks' => $totalTrucks,
            'totalGpsDevices' => $totalGpsDevices,
            'weatherData' => $weatherData,
        ]);
    }

}
