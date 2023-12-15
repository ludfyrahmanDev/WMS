<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\SpendingCategory;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleService extends Controller
{
    public function index(Request $request)
    {

    }

    public function create()
    {
        $driver = new Driver;
        $vehicle = new Vehicle;
        $spendingCategory = new SpendingCategory;

        $data['driver'] = $driver->select('id', 'name')->get();
        $data['vehicle'] = $vehicle->select('id', 'name')->get();
        $daata['spendingCategory'] = $spendingCategory->select('id', 'spending_category')->where('spending_types', 'kendaraan');

        $title = 'Data Servis Kendaraan';
        $route = route('vehicle_service.store');
        $type = 'create';

        return view('pages.backoffice.vehicle_service._form', compact('data', 'title', 'route', 'type'));
    }
}
