<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trucks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TruckController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $trucks = Trucks::with(['truck_services' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->when($search, function ($query, $search) {
            return $query->where('number_plate', 'like', '%' . $search . '%')
                        ->orWhere('license_number', 'like', '%' . $search . '%');
        })
        ->orderBy('number_plate', 'asc')
        ->paginate(10);

        return view('admin.truckInfo.index', ['trucks' => $trucks]);
        // return response()->json($trucks, 200);
    }

    public function create()
    {
        return view('admin.truckInfo.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number_plate' => 'required|numeric|unique:trucks,number_plate',
            'truck_capacity' => 'required|numeric',
            'fuel_capacity' => 'required|numeric',
            'license_number' => 'required|numeric|unique:trucks,license_number',
            'created_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $createdDate = Carbon::parse($request->created_date);

        $expiredDate = $createdDate->copy()->addDays(30);
        $request->merge(['expired_date' => $expiredDate->toDateString()]);

        $licenseStatus = $request->input('license_status', 'active');

        // Gabungkan license_status ke request
        $request->merge(['license_status' => $licenseStatus]);

        $truck = Trucks::create($request->all());

        return redirect()->route('trucks.store')
                         ->with('success', 'Truck berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $trucks = Trucks::find($id);
        return view('admin.truckInfo.edit', ['trucks' => $trucks]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'number_plate' => "required|numeric|unique:trucks,number_plate,$id",
            'truck_capacity' => 'required|numeric',
            'fuel_capacity' => 'required|numeric',
            'license_number' => "required|numeric|unique:trucks,license_number,$id",
            'created_date' => 'required|date',
            'expired_date' => 'required|date',
            'license_status' => 'required|in:active,need an update,expired',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $createdDate = Carbon::parse($request->created_date);

        $expiredDate = $createdDate->copy()->addDays(30);
        $request->merge(['expired_date' => $expiredDate->toDateString()]);

        $now = Carbon::now()->startOfDay();

        $diffDate = $now->diffInDays($expiredDate->startOfDay());

        if ($now->gt($expiredDate)) {
            $licenseStatus = 'expired';
        } elseif ($diffDate <= 7) {
            $licenseStatus = 'need an update';
        } else {
            $licenseStatus = 'active';
        }

        $request->merge(['license_status' => $licenseStatus]);

        $truck = Trucks::find($id);
        $truck->update($request->all());

        return redirect()->route('trucks.index')
                         ->with('success', 'Truck berhasil diupdate.');
    }

    public function destroy(Request $request, $id)
    {
        $trucks = Trucks::find($id);
        $trucks->forceDelete();
        return redirect()->route('trucks.index')
                         ->with('success', 'Truck berhasil dihapus.');
    }




}
