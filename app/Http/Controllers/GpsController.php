<?php

namespace App\Http\Controllers;

use App\Models\Gps;
use App\Models\Trucks;
use Illuminate\Http\Request;

class GpsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $gpsLoc = Gps::with('trucks')
        ->when($search, function ($query, $search) {
            return $query->whereHas('trucks', function ($query) use ($search) {
                $query->where('number_plate', 'like', '%' . $search . '%');
            })->orWhere('device_id', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);;
        return view('admin.gps.index', ['gpsLoc' => $gpsLoc]);
    }

    public function create()
    {
        $trucks = Trucks::all();
        return view('admin.gps.create', compact('trucks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'device_id' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        Gps::create($request->all());
        return redirect()->route('gps.index')->with('success', 'GPS berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gps = Gps::find($id);
        $trucks = Trucks::all();
        return view('admin.gps.edit', ['gps' => $gps, 'trucks' => $trucks]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'device_id' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        $gps = Gps::find($id);
        $gps->update($request->all());
        return redirect()->route('gps.index')->with('success', 'GPS berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $gps = Gps::find($id);
        $gps->delete();
        return redirect()->route('gps.index')->with('success', 'GPS berhasil dihapus.');
    }

}
