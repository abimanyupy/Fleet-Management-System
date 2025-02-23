<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HaulingRoutes;
use Illuminate\Support\Facades\Validator;

class HaulingRoutesController extends Controller
{
    public function index()
    {
        $haulingRoute = HaulingRoutes::with('haulingRouteWeather')->paginate(10);
        return view('admin.hauling.index', ['haulingRoute' => $haulingRoute]);
    }

    public function create()
    {
        $haulingRoute = HaulingRoutes::get();
        return view('admin.hauling.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_name' => 'required',
            'length' => 'required|numeric',
            'estimation_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        HaulingRoutes::create($request->all());

        return redirect()->route('hauling-route.index')
                         ->with('success', 'Route berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $haulingRoute = HaulingRoutes::find($id);
        return view('admin.hauling.edit', ['haulingRoute' => $haulingRoute]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'route_name' => 'required',
            'length' => 'required|numeric',
            'estimation_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $haulingRoute = HaulingRoutes::find($id);
        $haulingRoute->update($request->all());

        return redirect()->route('hauling-route.index')
                         ->with('success', 'Route berhasil diupdate.');
    }

    public function destroy(Request $request, $id)
    {
        $haulingRoute = HaulingRoutes::find($id);
        $haulingRoute->forceDelete();
        return redirect()->route('hauling-route.index')
                         ->with('success', 'Route berhasil dihapus.');
    }
}
