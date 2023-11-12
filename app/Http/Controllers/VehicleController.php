<?php

namespace App\Http\Controllers;

use App\Http\Requests\Master\VehicleStoreRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $data = Vehicle::filterResource($request, [
            'name',
            'license_plate',
            'brand',
        ], [])
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
        ->paginate($request->get('per_page', 10));

        $title = 'Data Kendaraan';
        $route = 'vehicle';
        return view('pages.backoffice.vehicle.index', compact('data', 'title', 'route'));
    }

    public function create()
    {
        $data = (object)[
            'name' => '',
            'license_plate' => '',
            'brand' => ''
        ];

        $title = 'Data Kendaraan';
        $route = route('vehicle.store');
        $type = 'create';

        return view('pages.backoffice.vehicle._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(VehicleStoreRequest $request) 
    {
        try {
            $vehicle = new Vehicle();
            $vehicle->name = $request->name;
            $vehicle->license_plate = $request->license_plate;
            $vehicle->brand = $request->brand;
            $vehicle->save();

            return redirect('vehicle')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->withErrors($request->getValidator())->with('failed', 'Gagal menambah data!');
        }
    }

    public function edit(Vehicle $vehicle)
    {
        $data = $vehicle;
        $title = 'Data Kendaraan';
        $route = route('vehicle.update', $vehicle);
        $type = 'edit';

        return view('pages.backoffice.vehicle._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(VehicleStoreRequest $request, Vehicle $vehicle)
    {
        try {
            $vehicle->name = $request->name;
            $vehicle->license_plate = $request->license_plate;
            $vehicle->brand = $request->brand;
            $vehicle->save();

            return redirect('vehicle')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();

            return redirect('vehicle')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }
}
