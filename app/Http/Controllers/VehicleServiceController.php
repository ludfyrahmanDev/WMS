<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\VehicleService;
use App\Models\SpendingCategory;
use App\Models\Spending;
use App\Models\VehicleServiceDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VehicleServiceExport;
use App\Http\Requests\Transaksi\VehicleServiceStoreRequest;
use Dompdf\Dompdf;
use Dompdf\Options;

class VehicleServiceController extends Controller
{
    public function index(Request $request)
    {
        $all = VehicleService::filterResource($request, [
            'date',
            'driver.name',
            'vehicle.name'
        ], [])
            ->with('driver', 'vehicle', 'vehicleServiceDetail')
            ->orderBy($request->get('sort_by', 'date'), $request->get('order', 'desc'));
        $total = 0;
        if($request->has('start_date') && $request->has('end_date')){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('created_at', [$start_date, $end_date]);
        }
        foreach ($all->get() as $key => $value) {
            foreach ($value->vehicleServiceDetail as $key => $value) {
                $total += $value->amount_of_expenditure;
            }
        }

        $cekSaldo = new SpendingController();

        $saldo = $cekSaldo->saldoKendaraan($request);

        $data = $all->paginate($request->get('per_page', 10));
        $title = 'Data Servis Kendaraan';
        $route = 'vehicle_service';
        $request = $request->toArray();

        return view('pages.backoffice.vehicle_service.index', compact('data', 'request','title', 'route', 'request', 'total', 'saldo'));
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
        // $data['spendingCategory'] = $vehicleService->getSpendingCategory();

        $title = 'Data Servis Kendaraan';
        $route = route('vehicle_service.store');
        $type = 'create';

        return view('pages.backoffice.vehicle_service._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(VehicleServiceStoreRequest $request)
    {
        $user = auth()->user();

        try {
            // cek saldo
            $totalKeterangan = COUNT($request->keterangan);

            $totalHarga = 0;
            for ($i = 0; $i < $totalKeterangan; $i++) {
                $totalHarga += intval($request->total_pengeluaran[$i]);
            }

            $saldo = new SpendingController();

            $cekSaldo = $saldo->saldoKendaraan($request);

            if (intval($totalHarga) > intval($cekSaldo)) {
                return back()->with('failed', 'Gagal, saldo tidak cukup!');
            }
            // selesai total harga

            $vehicleService = new VehicleService();
            $vehicleService->date = $request->tanggal;
            $vehicleService->driver_id = $request->driver;
            $vehicleService->vehicle_id = $request->kendaraan;
            $vehicleService->who_create = $user['name'];
            $vehicleService->who_update = $user['name'];
            $vehicleService->save();

            for ($i = 0; $i < $totalKeterangan; $i++) {
                $vehicleServiceDetail = new VehicleServiceDetail();
                $vehicleServiceDetail->vehicle_service_id = $vehicleService->id;
                // $vehicleServiceDetail->spending_category_id = $request->kategori_id[$i];
                $vehicleServiceDetail->amount_of_expenditure = curencyToInteger($request->total_pengeluaran[$i]);
                $vehicleServiceDetail->description = $request->keterangan[$i];
                $vehicleServiceDetail->save();
            }

            return redirect(route('vehicle_service.index'))->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!' . $th->getMessage());
        }
    }

    public function destroy(VehicleService $vehicleService)
    {
        try {
            $vehicleService->delete();
            return redirect(route('vehicle_service.index'))->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('failed', 'Gagal menghapus data!' . $th->getMessage());
        }
    }

    public function edit(VehicleService $vehicleService)
    {
        // $vehicleService->load('vehicleServiceDetail.spendingCategory');

        $data['driver'] = $vehicleService->getDriver();
        $data['vehicle'] = $vehicleService->getVehicle();
        // $data['spendingCategory'] = $vehicleService->getSpendingCategory();
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
            // cek saldo
            $totalKeterangan = COUNT($request->keterangan);

            $totalHarga = 0;
            for ($i = 0; $i < $totalKeterangan; $i++) {
                $totalHarga += intval($request->total_pengeluaran[$i]);
            }

            $saldo = new SpendingController();

            $cekSaldo = $saldo->saldoKendaraan($request);

            if (intval($totalHarga) > intval($cekSaldo)) {
                return back()->with('failed', 'Gagal, saldo tidak cukup!');
            }
            // selesai total harga

            // update table vehicle service
            $vehicleService->date = $request->tanggal;
            $vehicleService->driver_id = $request->driver;
            $vehicleService->vehicle_id = $request->kendaraan;
            $vehicleService->who_update = $user['name'];
            $vehicleService->save();

            // delete vehicle service detail
            $vehicleService->vehicleServiceDetail()->delete();

            // insert vehicle service detail
            $totalKeterangan = COUNT($request->keterangan);

            for ($i = 0; $i < $totalKeterangan; $i++) {
                $vehicleServiceDetail = new VehicleServiceDetail();
                $vehicleServiceDetail->vehicle_service_id = $vehicleService->id;
                // $vehicleServiceDetail->spending_category_id = $request->kategori_id[$i];
                $vehicleServiceDetail->amount_of_expenditure = curencyToInteger($request->total_pengeluaran[$i]);
                $vehicleServiceDetail->description = $request->keterangan[$i];
                $vehicleServiceDetail->save();
            }

            return redirect(route('vehicle_service.index'))->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
        }
    }

    public function export(Request $request)
    {
        $name = 'Data Servis Kendaraan - ' . date('Y-m-d');
        $fileName = $name . '.xlsx';
        Excel::store(new VehicleServiceExport($request), 'public/excel/' . $fileName);
        return Excel::download(new VehicleServiceExport($request), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $all = VehicleService::with(['driver', 'vehicle', 'vehicleServiceDetail', 'vehicleServiceDetail.spendingCategory'])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
            if($request->has('start_date') && $request->has('end_date')){
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $all = $all->whereBetween('created_at', [$start_date, $end_date]);
            }
        
        $data = $all->get();
        $title = 'Data Transaksi Lain Lain';

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        // Inisialisasi Dompdf dengan opsi yang telah disetel
        $dompdf = new Dompdf($options);

        $html = view('pages.backoffice.vehicle_service.export', compact('data', 'title'))->render();

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set paper size (jika diperlukan)
        $dompdf->setPaper('a4', 'landscape');

        // Render PDF (output ke browser atau simpan ke file)
        $dompdf->render();

        // Nama file untuk diunduh
        $name = 'laporan_servis_kendaraan_' . date('d-m-Y');

        // Unduh file PDF
        return $dompdf->stream("$name.pdf");
    }
}
