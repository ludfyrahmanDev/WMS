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
use App\Http\Requests\Transaksi\VehicleServiceRequest;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
class VehicleServiceController extends Controller
{
    public function index(Request $request)
    {
        $selectedCvId = session('cv_id');
        
        $all = VehicleService::filterResource($request, [
            'date',
            'driver.name',
            'vehicle.name'
        ], [])
            ->when($selectedCvId && auth()->user()->hasCompanyAccess(), function ($query) use ($selectedCvId) {
                $query->where('cv_id', $selectedCvId);
            })
            ->with(['driver', 'vehicle', 'vehicleServiceDetail', 'cv'])
            ->orderBy($request->get('sort_by', 'date'), $request->get('order', 'desc'));
        $total = 0;
        if($request->has('start_date') && $request->has('end_date')){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('date', [$start_date, $end_date]);
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

        return view('pages.backoffice.vehicle_service.index', compact('data', 'request', 'title', 'route', 'total', 'saldo'));
    }

    public function create()
    {
        $selectedCvId = session('cv_id');
        $cvs = auth()->user()->getAccessibleCvs();
        
        $data['header'] = (object)[
            'date' => null,
            'driver_id' => null,
            'vehicle_id' => null,
            'cv_id' => $selectedCvId
        ];

        $vehicleService = new VehicleService;

        $data['driver'] = $vehicleService->getDriver();
        $data['vehicle'] = $vehicleService->getVehicle();
        $data['cvs'] = $cvs;

        $title = 'Tambah Servis Kendaraan';
        $route = route('vehicle_service.store');
        $type = 'create';

        return view('pages.backoffice.vehicle_service._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(VehicleServiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            
            // Get payment method from the request (first item from array)
            $paymentMethod = $data['payment_method'][0] ?? 'CASH';
            
            $vehicleData = [
                'date' => $data['tanggal'],
                'driver_id' => $data['driver'],
                'vehicle_id' => $data['kendaraan'],
                'cv_id' => $data['cv_id'] ?? session('cv_id'),
                'payment_method' => $paymentMethod,
                'who_create' => auth()->user()->name,
                'who_update' => auth()->user()->name,
            ];

            $vehicleService = VehicleService::create($vehicleData);
            
            $totalExpenditure = 0;

            // keterangan
            foreach ($request->keterangan as $index => $keterangan) {
                $amount = curencyToInteger($request->total_pengeluaran[$index]);
                $totalExpenditure += $amount;
                
                $vehicleServiceDetail = new VehicleServiceDetail();
                $vehicleServiceDetail->vehicle_service_id = $vehicleService->id;
                $vehicleServiceDetail->amount_of_expenditure = $amount;
                $vehicleServiceDetail->description = $keterangan;
                $vehicleServiceDetail->payment_method = $request->payment_method[$index] ?? 'CASH';
                $vehicleServiceDetail->save();
            }
            
            // Create Spending record to deduct from neraca angkutan
            $this->createSpendingRecord($vehicleService->cv_id, $paymentMethod, $totalExpenditure, $vehicleService);

            DB::commit();

            return redirect()->route('vehicle_service.index');
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'data' => null,
                'message' => $e->getMessage()
            ], 500);
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
        $cvs = auth()->user()->getAccessibleCvs();

        $data['driver'] = $vehicleService->getDriver();
        $data['vehicle'] = $vehicleService->getVehicle();
        $data['cvs'] = $cvs;
        $data['header'] = $vehicleService;
        $data['detail'] = $vehicleService->vehicleServiceDetail;

        $title = 'Edit Servis Kendaraan';
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
            // selesai total harga
            
            // Get payment method from the request (first item from array)
            $paymentMethod = $request->payment_method[0] ?? 'CASH';

            // update table vehicle service
            $vehicleService->date = $request->tanggal;
            $vehicleService->driver_id = $request->driver;
            $vehicleService->vehicle_id = $request->kendaraan;
            $vehicleService->cv_id = $request->cv_id ?? session('cv_id');
            $vehicleService->payment_method = $paymentMethod;
            $vehicleService->who_update = $user['name'];
            $vehicleService->save();

            // delete vehicle service detail
            $vehicleService->vehicleServiceDetail()->delete();

            // insert vehicle service detail
            $totalKeterangan = COUNT($request->keterangan);
            $totalExpenditure = 0;

            for ($i = 0; $i < $totalKeterangan; $i++) {
                $amount = curencyToInteger($request->total_pengeluaran[$i]);
                $totalExpenditure += $amount;
                
                $vehicleServiceDetail = new VehicleServiceDetail();
                $vehicleServiceDetail->vehicle_service_id = $vehicleService->id;
                // $vehicleServiceDetail->spending_category_id = $request->kategori_id[$i];
                $vehicleServiceDetail->amount_of_expenditure = $amount;
                $vehicleServiceDetail->description = $request->keterangan[$i];
                $vehicleServiceDetail->payment_method = $request->payment_method[$i] ?? 'CASH';
                $vehicleServiceDetail->save();
            }
            
            // Create/Update Spending record to deduct from neraca angkutan
            $this->createSpendingRecord($vehicleService->cv_id, $paymentMethod, $totalExpenditure, $vehicleService);

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
                $all = $all->whereBetween('date', [$start_date, $end_date]);
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

    private function createSpendingRecord($cvId, $paymentMethod, $totalExpenditure, $vehicleService)
    {
        // Get the Saldo Kendaraan spending category
        $saldoKendaraanCategory = SpendingCategory::where('spending_category', 'Saldo Kendaraan')->first();
        
        if (!$saldoKendaraanCategory) {
            return;
        }
        
        // Check if a spending record already exists for this vehicle service
        $existingSpending = Spending::where('spending_category_id', $saldoKendaraanCategory->id)
            ->where('cv_id', $cvId)
            ->where('description', 'like', '%Vehicle Service #' . $vehicleService->id . '%')
            ->first();
        
        if ($existingSpending) {
            // Update existing record
            $existingSpending->nominal = -$totalExpenditure;
            $existingSpending->payment_method = $paymentMethod;
            $existingSpending->save();
        } else {
            // Create new spending record (negative nominal for deduction)
            Spending::create([
                'spending_category_id' => $saldoKendaraanCategory->id,
                'cv_id' => $cvId,
                'payment_method' => $paymentMethod,
                'nominal' => -$totalExpenditure,
                'description' => 'Vehicle Service #' . $vehicleService->id . ' - ' . $vehicleService->vehicle->license_plate . ' (' . $vehicleService->date . ')'
            ]);
        }
    }
}
