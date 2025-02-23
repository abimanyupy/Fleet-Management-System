<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trucks;
use App\Models\Drivers;
use App\Models\FuelLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FuelLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $fuelLogs = FuelLog::with(['trucks', 'driver'])
        ->when($search, function ($query, $search) {
            return $query->whereHas('trucks', function ($query) use ($search) {
                $query->where('number_plate', 'like', '%' . $search . '%');
            })->orWhereHas('driver', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('refuel_date', 'desc')
        ->paginate(10);

        return view('admin.fuelLogs.index', ['fuelLogs' => $fuelLogs]);
    }

    public function create()
    {
        $trucks = Trucks::orderBy('number_plate', 'asc')->get();
        $drivers = Drivers::orderBy('name', 'asc')->get();
        return view('admin.fuelLogs.create', ['trucks' => $trucks, 'drivers' => $drivers]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'truck_id' => 'required|exists:trucks,id',
            'driver_id' => 'required|exists:drivers,id',
            'refuel_date' => 'required|date',
            'liters_filled' => 'required|numeric',
        ]);


        $request->merge(['cost'=> $request->liters_filled * 22000,]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $refuelDate = Carbon::parse($request->refuel_date);

        // Atur waktu ke waktu saat ini
        $refuelDate->setTimeFromTimeString(Carbon::now()->toTimeString());

        // Gabungkan tanggal dan waktu ke dalam request
        $request->merge(['refuel_date' => $refuelDate]);

        $fuelLog = FuelLog::create($request->all());

        return redirect()->route('fuel-logs.index')
                         ->with('success', 'Fuel Log berhasil ditambahkan.');
    }

    public function destroy(Request $request, $id)
    {
        $fuelLog = FuelLog::find($id);
        $fuelLog->forceDelete();
        return redirect()->route('fuel-logs.index')
                         ->with('success', 'Fuel Log berhasil dihapus.');
    }
}
