<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\VehicleService;
use App\Models\SpendingCategory;
use App\Models\VehicleServiceDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VehicleServiceExport;
use App\Http\Requests\Transaksi\VehicleServiceStoreRequest;

class VehicleServiceController extends Controller
{
    public function index(Request $request)
    {
        $data = VehicleService::filterResource($request, [
            'date',
            'driver.name',
            'vehicle.name'
        ], [])
            ->with('driver', 'vehicle')
            ->orderBy($request->get('sort_by', 'date'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));

        $title = 'Data Servis Kendaraan';
        $route = 'vehicle_service';
        $request = $request->toArray();

        return view('pages.backoffice.vehicle_service.index', compact('data', 'title', 'route', 'request'));
    }

    public function create()
    {
        $data['header'] = (object)[
            'date' => null,
            'driver_id' => null,
            'vehicle_id' => null
        ];

        $vehicleService = new VehicleService;

        // $driver = new Driver;
        // $vehicle = new Vehicle;
        // $spendingCategory = new SpendingCategory;

        // $data['driver'] = $driver->select('id', 'name')->get();
        // $data['vehicle'] = $vehicle->select('id', 'name', 'license_plate')->get();
        // $data['spendingCategory'] = $spendingCategory->select('id', 'spending_category')->where('spending_types', 'kendaraan')->get();

        $data['driver'] = $vehicleService->getDriver();
        $data['vehicle'] = $vehicleService->getVehicle();
        $data['spendingCategory'] = $vehicleService->getSpendingCategory();

        $title = 'Data Servis Kendaraan';
        $route = route('vehicle_service.store');
        $type = 'create';

        return view('pages.backoffice.vehicle_service._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(VehicleServiceStoreRequest $request)
    {
        $user = auth()->user();

        try {
            $vehicleService = new VehicleService();
            $vehicleService->date = $request->tanggal;
            $vehicleService->driver_id = $request->driver;
            $vehicleService->vehicle_id = $request->kendaraan;
            $vehicleService->who_create = $user['name'];
            $vehicleService->who_update = $user['name'];
            $vehicleService->save();

            $totalKategori = COUNT($request->kategori_id);

            for ($i = 0; $i < $totalKategori; $i++) {
                $vehicleServiceDetail = new VehicleServiceDetail();
                $vehicleServiceDetail->vehicle_service_id = $vehicleService->id;
                $vehicleServiceDetail->spending_category_id = $request->kategori_id[$i];
                $vehicleServiceDetail->amount_of_expenditure = $request->total_pengeluaran[$i];
                $vehicleServiceDetail->description = $request->keterangan[$i];
                $vehicleServiceDetail->save();
            }

            return redirect(route('vehicle_service.index'))->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!');
        }
    }

    public function destroy(VehicleService $vehicleService)
    {
        try {
            $vehicleService->delete();
            return redirect(route('vehicle_service.index'))->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }

    public function edit(VehicleService $vehicleService)
    {
        $vehicleService->load('vehicleServiceDetail.spendingCategory');

        $data['driver'] = $vehicleService->getDriver();
        $data['vehicle'] = $vehicleService->getVehicle();
        $data['spendingCategory'] = $vehicleService->getSpendingCategory();
        $data['header'] = $vehicleService;
        $data['detail'] = $vehicleService->vehicleServiceDetail;

        $title = 'Data Servis Kendaraan';
        $route = route('vehicle_service.update', $vehicleService);
        $type = 'edit';

        return view('pages.backoffice.vehicle_service._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(VehicleServiceStoreRequest $request, VehicleService $vehicleService)
    {
        $user = auth()->user();

        try {
            // update table vehicle service
            $vehicleService->date = $request->tanggal;
            $vehicleService->driver_id = $request->driver;
            $vehicleService->vehicle_id = $request->kendaraan;
            $vehicleService->who_update = $user['name'];
            $vehicleService->save();

            // delete vehicle service detail
            $vehicleService->vehicleServiceDetail()->delete();

            // insert vehicle service detail
            $totalKategori = COUNT($request->kategori_id);

            for ($i = 0; $i < $totalKategori; $i++) {
                $vehicleServiceDetail = new VehicleServiceDetail();
                $vehicleServiceDetail->vehicle_service_id = $vehicleService->id;
                $vehicleServiceDetail->spending_category_id = $request->kategori_id[$i];
                $vehicleServiceDetail->amount_of_expenditure = $request->total_pengeluaran[$i];
                $vehicleServiceDetail->description = $request->keterangan[$i];
                $vehicleServiceDetail->save();
            }

            return redirect(route('vehicle_service.index'))->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!');
        }
    }

    public function export(Request $request)
    {
        $name = 'Data Servis Kendaraan ';
        $fileName = $name . '.xlsx';
        return Excel::download(new VehicleServiceExport($request), $fileName);
    }
}
