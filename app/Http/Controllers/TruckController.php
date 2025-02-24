<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trucks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $createdDate = Carbon::parse($request->created_date);
        $expiredDate = $createdDate->copy()->addDays(30);

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

    public function checkLicenseExpiration()
    {
        $now = Carbon::now();
        $warningDate = $now->copy()->addDays(7);

        // Ambil truk dengan lisensi yang akan segera kedaluwarsa atau sudah kedaluwarsa
        $trucks = Trucks::where('expired_date', '<=', $warningDate)
                        ->orderBy('expired_date', 'asc')
                        ->get();

        $updatedTrucks = 0;

        foreach ($trucks as $truck) {
            // Perbarui status lisensi berdasarkan tanggal kedaluwarsa
            if ($now->gt($truck->expired_date)) {
                $licenseStatus = 'expired';
            } elseif ($now->diffInDays($truck->expired_date) <= 7) {
                $licenseStatus = 'need an update';
            } else {
                $licenseStatus = 'active';
            }

            // Update status lisensi truk
            $truck->update([
                'license_status' => $licenseStatus,
            ]);

            $updatedTrucks++;
            Log::info("Truk {$truck->id} dengan nomor plat {$truck->number_plate} diperbarui status lisensinya menjadi {$licenseStatus}.");
        }

        return response()->json([
            'message' => "{$updatedTrucks} truk diperbarui status lisensinya."
        ]);
    }


}
