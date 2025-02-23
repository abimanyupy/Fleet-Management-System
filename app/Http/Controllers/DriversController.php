<?php

namespace App\Http\Controllers;

use App\Models\Drivers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriversController extends Controller
{
    public function index(Request $request)
    {
        // $drivers = Drivers::orderBy('name', 'asc')->paginate(10);
        $search = $request->input('search');
        $drivers = Drivers::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('driver_status', 'like', '%' . $search . '%');
        })
        ->orderBy('name', 'asc')
        ->paginate(10);
        return view('admin.driver.index', ['drivers' => $drivers]);
        // return response()->json($drivers, 200);
    }

    public function create()
    {
        return view('admin.driver.create');
    }

    public function store(Request $request)
    {
        $request->merge(['driver_status' => $request->driver_status ?? 'active']);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:drivers,email',
            'phone' => 'required|digits_between:10,15|numeric|unique:drivers,phone',
            'license_number' => 'required|string|unique:drivers,license_number',
            'driver_status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $drivers = Drivers::create($request->all());

        return redirect()->route('drivers.store')
                         ->with('success', 'Driver berhasil ditambahkan.');
    }

     public function show($id)
    {
        $drivers = Drivers::find($id);
        return view('admin.driver.show', ['drivers' => $drivers]);
    }

    public function edit($id)
    {
        $drivers = Drivers::find($id);
        return view('admin.driver.edit', ['drivers' => $drivers]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'email' => "required|email|unique:drivers,email,$id",
            'phone' => "required|digits_between:10,15|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|unique:drivers,phone,$id",
            'license_number' => "required|string|unique:drivers,license_number,$id",
            'driver_status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       $drivers = Drivers::find($id);
       $drivers->update($request->all());

        return redirect()->route('drivers.index')
                         ->with('success', 'Driver berhasil diupdate.');
    }

    public function destroy(Request $request, $id)
    {
        $drivers = Drivers::find($id);
        $drivers->forceDelete();
        return redirect()->route('drivers.index')
                         ->with('success', 'Driver berhasil dihapus.');
    }
}
