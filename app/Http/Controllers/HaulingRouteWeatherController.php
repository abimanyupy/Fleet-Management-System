<?php

namespace App\Http\Controllers;

use App\Models\HaulingRoutes;
use Illuminate\Http\Request;
use App\Models\HaulingRouteWeather;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HaulingRouteWeatherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $haulingWeather = HaulingRouteWeather::with('hauling_route')
        ->when($search, function ($query, $search) {
            return $query->where('kilometer', 'like', '%' . $search . '%')
                        ->orWhere('weather_condition', 'like', '%' . $search . '%');
        })
        ->orderBy('kilometer', 'desc')
        ->paginate(10);
        // dd($haulingWeather);

        return view('admin.haulingWeather.index', ['haulingWeather' => $haulingWeather]);
    }

    public function create()
    {
        $haulingWeather = HaulingRouteWeather::orderBy('kilometer', 'asc')->get();
        $haulingRoute = HaulingRoutes::orderBy('route_name', 'asc')->get();

        return view('admin.haulingWeather.create', ['haulingWeather' => $haulingWeather, 'haulingRoute' => $haulingRoute]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required|exists:hauling_routes,id',
            'kilometer' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'weather_condition' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $haulingWeather = HaulingRouteWeather::create($request->all());
        return redirect()->route('hauling-route-weather.index')
                         ->with('success', 'Hauling Weather berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $haulingWeather = HaulingRouteWeather::findOrFail($id);
        $haulingRoute = HaulingRoutes::all();
        return view('admin.haulingWeather.edit', ['haulingWeather' => $haulingWeather, 'haulingRoute' => $haulingRoute]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required|exists:hauling_routes,id',
            'kilometer' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'weather_condition' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $haulingWeather = HaulingRouteWeather::find($id);
        $haulingWeather->update($request->all());

        return redirect()->route('hauling-route-weather.index')
                         ->with('success', 'Hauling Weather berhasil diubah.');
    }

    public function destroy($id)
    {
        $haulingWeather = HaulingRouteWeather::find($id);
        $haulingWeather->forceDelete();
        return redirect()->route('hauling-route-weather.index')
                         ->with('success', 'Hauling Weather berhasil dihapus.');
    }


}
