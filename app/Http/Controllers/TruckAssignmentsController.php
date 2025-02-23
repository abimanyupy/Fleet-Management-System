<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trucks;
use App\Models\Drivers;
use Illuminate\Http\Request;
use App\Models\HaulingRoutes;
use App\Models\TruckAssignments;
use Illuminate\Support\Facades\Validator;

class TruckAssignmentsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $truckAssignments = TruckAssignments::with('trucks', 'driver', 'haulling_route')
        ->when($search, function ($query, $search) {
            return $query->whereHas('trucks', function ($query) use ($search) {
                $query->where('number_plate', 'like', '%' . $search . '%');
            })->orWhereHas('driver', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('admin.truckAssignment.index', ['truckAssignments' => $truckAssignments]);
    }

    public function create()
    {
        $trucks = Trucks::orderBy('number_plate', 'asc')->get();
        $drivers = Drivers::orderBy('name', 'asc')->get();
        $haullingRoutes = HaulingRoutes::orderBy('route_name', 'asc')->get();

        return view('admin.truckAssignment.create', ['trucks' => $trucks, 'drivers' => $drivers, 'haullingRoutes' => $haullingRoutes]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'truck_id' => 'required|exists:trucks,id',
            'driver_id' => 'required|exists:drivers,id',
            'hauling_route_id' => 'required|exists:hauling_routes,id',
            'total_load' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $request->all();
        $data['assignment_date'] = now();
        $data['deparature_time'] = now();
        // $departureTime = Carbon::createFromFormat('H:i:s', $request->departure_time);
        // $arrivalTime = $departureTime->copy()->addMinutes(rand(10, 180));
        // $request->merge(['arrival_time' => $arrivalTime->format('H:i:s')]);
        // dd($data);

        $truckAssignment = TruckAssignments::create($data);

        return redirect()->route('truck-assignment.index')
                         ->with('success', 'Truck Assignment berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $truckAssignment = TruckAssignments::find($id);
        return view('admin.truckAssignment.edit', ['truckAssignment' => $truckAssignment]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $truckAssignment = TruckAssignments::findOrFail($id);


        $arrivalTime = now();
        $departureTime = Carbon::parse($truckAssignment->departure_time);
        $cycleTime = $departureTime->diffInMinutes($arrivalTime);

        // Update data
        $truckAssignment->update([
            'arrival_time' => $arrivalTime,
            'cycle_time' => $cycleTime,
            'notes' => $request->notes, // Update notes jika ada
        ]);


        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('truck-assignment.index')
                        ->with('success', 'Truck Assignment berhasil diupdate.');
    }

    public function destroy($id)
    {
        $truckAssignment = TruckAssignments::find($id);
        $truckAssignment->forceDelete();
        return redirect()->route('truck-assignment.index')
                         ->with('success', 'Truck Assignment berhasil dihapus.');
    }


}
