<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trucks;
use App\Models\TruckService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TruckServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $trucksService = TruckService::with('trucks')
        ->when($search, function ($query, $search) {
            return $query->where('service_status', 'like', '%' . $search . '%') // Cari berdasarkan service_status
                         ->orWhereHas('trucks', function ($q) use ($search) {
                             $q->where('number_plate', 'like', '%' . $search . '%'); // Cari berdasarkan number_plate di tabel trucks
                         })->orWhere('service_description', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        foreach ($trucksService as $service) {
            $service->buttonData = $this->getButtonData($service);
        }

        return view('admin.truckService.index', ['trucksService' => $trucksService]);
        // return response()->json($trucksService, 200);
    }

    public function create()
    {
        $trucks = Trucks::orderBy('number_plate', 'asc')->get();

        return view('admin.truckService.create', ['trucks' => $trucks]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'truck_id' => ['required', 'exists:trucks,id'],
            'service_description' => 'required',
            // 'start_service_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $serviceStatus = $request->input('service_status', 'NEED REPAIR');
        $isServiced = $request->input('is_serviced', false);

        $request->merge(['is_serviced' => false, 'service_status' => $serviceStatus]);

        $trucksService = TruckService::create($request->all());

        return redirect()->route('truck-service.index')
                         ->with('success', 'Truck Service berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $trucksService = TruckService::find($id);
        return view('admin.truckService.edit', ['trucksService' => $trucksService]);
    }

    public function update(Request $request, $id)
    {
       $trucksService = TruckService::findOrFail($id);

        // Jika status saat ini adalah "READY", ubah menjadi "IN SERVICE"
        if ($trucksService->service_status === 'NEED REPAIR') {
            $trucksService->service_status = 'IN SERVICE';
            $trucksService->is_serviced = false;
            $trucksService->start_service_date = now();
            $trucksService->save();

            return redirect()->route('truck-service.index')
                            ->with('success', 'Truck Service berubah menjadi IN SERVICE.');
        }

        // Jika status saat ini adalah "IN SERVICE", ubah menjadi "READY"
        if ($trucksService->service_status === 'IN SERVICE') {
            $now = Carbon::now();
            $nextServiceDate = $now->copy()->addDays(30);

            $trucksService->service_status = 'READY';
            $trucksService->is_serviced = true;
            $trucksService->finish_service_date = $now;
            $trucksService->next_service_date = $nextServiceDate;
            $trucksService->save();

            return redirect()->route('truck-service.index')
                            ->with('success', 'Truck Service berubah menjadi READY.');
        }

        return redirect()->route('truck-service.index')
                        ->with('error', 'Tidak dapat mengubah status Truck Service.');
    }

    public function destroy(Request $request, $id)
    {
        $trucksService = TruckService::find($id);
        $trucksService->forceDelete();
        return redirect()->route('truck-service.index')
                         ->with('success', 'Truck Service berhasil dihapus.');
    }

    public function checkUpcomingService()
    {
        $now = Carbon::now();
        $warningDate = $now->copy()->addDays(7);

        $latestTrucks  = TruckService::where('service_status', 'READY')
        ->orderBy('updated_at', 'desc')
        ->get()
        ->unique('truck_id');

        $trucks = $latestTrucks->filter(function ($truck) use ($warningDate) {
            return $truck->next_service_date <= $warningDate;
        });
        $trucks = $trucks->values();

        $createdServices = 0;

        foreach ($trucks as $truck) {
            $truck->update([
                'service_status' => 'READY'
            ]);

            $newService = TruckService::create([
                'truck_id'            => $truck->truck_id,
                'service_description' => 'Automatic Repair Reminder',
                'service_status'      => 'NEED REPAIR',
                'is_serviced'         => false,
                'start_service_date'  => null,
                'finish_service_date' => null,
                'next_service_date'   => null
            ]);

            $createdServices++;
            Log::info("Truk {$truck->truck_id} dijadwalkan service baru pada {$newService->start_service_date}");
        }

        return response()->json([
            'message' => "{$createdServices} truk dijadwalkan untuk NEED REPAIR."
        ]);
    }

    public function getButtonData($service)
    {
        if ($service->service_status === 'NEED REPAIR') {
            return [
                'label' => 'Repair',
                'color' => 'bg-red-500 hover:bg-red-700',
                'confirm' => 'Apakah Anda yakin ingin memperbaiki truk ini?',
                'disabled' => false
            ];
        } elseif ($service->service_status === 'IN SERVICE') {
            return [
                'label' => 'Finish',
                'color' => 'bg-blue-500 hover:bg-blue-700',
                'confirm' => 'Apakah Anda yakin masa perbaikan sudah selesai?',
                'disabled' => false
            ];
        } else {
            return [
                'label' => 'Action',
                'color' => 'bg-yellow-500 hover:bg-yellow-700',
                'confirm' => 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
                'disabled' => true
            ];
        }
    }

    public function indexBTN()
    {
        $servicesBTN = TruckService::all();

        foreach ($servicesBTN as $service) {
            $service->buttonData = $this->getButtonData($service);
        }

        return view('admin.truckService.index', ['servicesBTN' => $servicesBTN]);
    }



}
