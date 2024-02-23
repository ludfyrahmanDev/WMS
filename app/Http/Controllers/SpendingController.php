<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Selling;
use App\Models\Spending;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\VehicleService;
use Carbon\Carbon;
use App\Exports\SpendingExport;
// import selling
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
// import delivery order
use Maatwebsite\Excel\Facades\Excel;
// import vehicle service
use App\Http\Requests\Transaksi\SpendingStoreRequest;
class SpendingController extends Controller
{
    public function index(Request $request)
    {
        $all = Spending::filterResource($request, [
            'date',
            'spendingCategory.spending_category',
            'mutation',
            'payment_method',
            'who_update',
        ], [])
        ->with('spendingCategory')
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        if($request->has('start_date') && $request->has('end_date')){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('date', [$start_date, $end_date]);
        }
        $income = $all->get()->where('mutation', 'Uang Masuk')->where('spendingCategory.spending_category', '<>', 'Saldo Kendaraan')->sum('nominal');
        $outcome = $all->get()->where('mutation', 'Uang Keluar')->sum('nominal');
        $sellingCompleted = Selling::whereIn('status', ['Completed', 'On Progress'])->sum('total_payment');
        $sellingInCompleted = Selling::where('status', '!=','Completed')->sum(\DB::raw('(grand_total - total_payment)'));
        $purchaseCompleted = DeliveryOrder::whereIn('status', ['Completed', 'On Progress'])->sum('total_payment');
        $purchaseInCompleted = DeliveryOrder::where('status', '!=','Completed')->sum((\DB::raw('(grand_total - total_payment)')));
        // $service = VehicleService::get();
        // $total = 0;
        // foreach ($service as $key => $value) {
        //     foreach ($value->vehicleServiceDetail as $key => $value) {
        //         $total += $value->amount_of_expenditure;
        //     }
        // }
        $saldo =( $income + $sellingCompleted) - ($outcome + $purchaseCompleted);
        $data = $all->paginate($request->get('per_page', 10));
        $title = 'Data Transaksi Lain Lain';
        $route = 'spending';
        $request = $request->toArray();

        return view('pages.backoffice.spending.index', compact('data', 'request','title', 'route', 'request', 'saldo', 'income', 'outcome', 'sellingCompleted', 'sellingInCompleted', 'purchaseCompleted', 'purchaseInCompleted'));
    }

    public function saldo(Request $request){
        $all = Spending::filterResource($request, [
            'date',
            'spendingCategory.spending_category',
            'mutation',
            'payment_method',
            'who_update',
        ], [])
        ->with('spendingCategory')
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        $income = $all->get()->where('mutation', 'Uang Masuk')->where('spendingCategory.spending_category', '<>', 'Saldo Kendaraan')->sum('nominal');
        $outcome = $all->get()->where('mutation', 'Uang Keluar')->sum('nominal');
        $sellingCompleted = Selling::whereIn('status', ['Completed', 'On Progress'])->sum('total_payment');
        $sellingInCompleted = Selling::where('status', '!=','Completed')->sum(\DB::raw('(grand_total - total_payment)'));
        $purchaseCompleted = DeliveryOrder::whereIn('status', ['Completed', 'On Progress'])->sum('total_payment');
        $purchaseInCompleted = DeliveryOrder::where('status', '!=','Completed')->sum((\DB::raw('(grand_total - total_payment)')));
        
        $saldo =( $income + $sellingCompleted) - ($outcome + $purchaseCompleted);
        return $saldo;
    }

    public function saldoKendaraan(Request $request){
        $all = Spending::filterResource($request, [
            'date',
            'spendingCategory.spending_category',
            'mutation',
            'payment_method',
            'who_update',
        ], [])
        ->with('spendingCategory')
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        $saldoKendaraan = $all->get()->where('spendingCategory.spending_category', 'Saldo Kendaraan')->sum('nominal');
        $service = VehicleService::get();
        $total = 0;
        foreach ($service as $key => $value) {
            foreach ($value->vehicleServiceDetail as $key => $value) {
                $total += $value->amount_of_expenditure;
            }
        }

        $saldo = ($saldoKendaraan ?? 0) - $total;
        return $saldo;
    }

    public function create()
    {
        $spending = new Spending;

        $kategori = $spending->getSpendingCategory();
        $enum = PaymentMethod::asOptions();

        $data = (object)[
            'date' => null,
            'mutation' => null,
            'description' => null,
            'spending_category_id' => null,
            'payment_method' => null,
            'nominal' => null
        ];

        $title = 'Data Transaksi Lain Lain';
        $route = route('spending.store');
        $type = 'create';

        return view('pages.backoffice.spending._form', compact('data', 'title', 'route', 'type', 'kategori', 'enum'));
    }

    public function store(SpendingStoreRequest $request)
    {
        $user = auth()->user();

        try {
            $spending = new Spending();
            $spending->date = $request->tanggal;
            $spending->mutation = $request->mutasi;
            $spending->spending_category_id = $request->spending_category;
            $spending->who_create = $user['name'];
            $spending->who_update = $user['name'];
            $spending->description = $request->description;
            $spending->payment_method = $request->payment_method;
            $spending->nominal = curencyToInteger($request->nominal);
            $spending->save();

            return redirect('spending')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }

    public function edit(Spending $spending)
    {
        $kategori = $spending->getSpendingCategory();
        $enum = PaymentMethod::asOptions();

        $data = $spending;
        $title = 'Data Transaksi Lain Lain';
        $route = route('spending.update', $spending);
        $type = 'edit';

        return view('pages.backoffice.spending._form', compact('kategori', 'enum', 'data', 'title', 'route', 'type'));
    }

    public function update(SpendingStoreRequest $request, Spending $spending)
    {
        $user = auth()->user();

        try {
            $spending->date = $request->tanggal;
            $spending->mutation = $request->mutasi;
            $spending->spending_category_id = $request->spending_category;
            $spending->who_update = $user['name'];
            $spending->description = $request->description;
            $spending->payment_method = $request->payment_method;
            $spending->nominal = curencyToInteger($request->nominal);
            $spending->save();

            return redirect('spending')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    public function destroy(Spending $spending)
    {
        try {
            $spending->delete();

            return redirect('spending')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!'.$th->getMessage());
        }
    }

    public function export(Request $request)
    {
        $name = 'Data Transaksi Lain Lain - ' . date('Y-m-d');
        $fileName = $name . '.xlsx';
        // save to storage
        Excel::store(new SpendingExport($request), 'public/excel/'.$fileName);
        return Excel::download(new SpendingExport($request), $fileName);
    }

    public function exportPdf(Request $request){
        $all = Spending::filterResource($request, [
            'date',
            'spendingCategory.spending_category',
            'mutation',
            'payment_method',
            'who_update',
        ], [])
        ->with('spendingCategory')
        ->whereHas('spendingCategory', function ($query) {
            $query->where('spending_category', '<>', 'Kendaraan');
        })
        ->orderBy($request->get('sort_by', 'date'), $request->get('order', 'desc'))
        ->orderBy($request->get('sort_by', 'spending_category_id'), $request->get('order', 'asc'))
        ->orderBy($request->get('sort_by', 'mutation'), $request->get('order', 'asc'))
        ->orderBy($request->get('sort_by', 'payment_method'), $request->get('order', 'asc'));
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

        $html = view('pages.backoffice.spending.export', compact('data', 'title'))->render();

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set paper size (jika diperlukan)
        $dompdf->setPaper('a4', 'landscape');

        // Render PDF (output ke browser atau simpan ke file)
        $dompdf->render();

        // Nama file untuk diunduh
        $name = 'laporan_pengeluaran_' . date('d-m-Y');

        // Unduh file PDF
        return $dompdf->stream("$name.pdf");
    }

    // make function send email
    public function sendEmail(){
        $request = new Request();
        $name = 'Laporan Transaksi Lain Lain';
        $now = date('Y-m-d');
        $spending = 'Data Transaksi Lain Lain - ' . $now . '.xlsx';
        $selling = 'Data Penjualan - ' . $now . '.xlsx';
        $purchase = 'Data Pembelian - ' . $now . '.xlsx';
        $service = 'Data Servis Kendaraan - ' . $now . '.xlsx';
        $this->export($request);
        $sellingController = new SellingController();
        $sellingController->export($request);
        $deliveryOrderController = new DeliveryOrderController();
        $deliveryOrderController->export($request);
        $vehicleServiceController = new VehicleServiceController();
        $vehicleServiceController->export($request);

        $report = [
                [
                    'title' => 'Data Transaksi Lain Lain',
                    'link' => asset('storage/excel/'.$spending)
                ],
                [
                    'title' => 'Data Penjualan',
                    'link' => asset('storage/excel/'.$selling)
                ],
                [
                    'title' => 'Data Pembelian',
                    'link' => asset('storage/excel/'.$purchase)
                ],
                [
                    'title' => 'Data Servis Kendaraan',
                    'link' => asset('storage/excel/'.$service)
                ]
            ];
        // send email
        $data = [
            'title' => 'Laporan Semua Transaksi Aplikasi WMS',
            'body' => 'Terlampir hasil laporan WMS',
            'desc' => 'Terlampir hasil laporan WMS',
            'email' => 'cs@putrabumiberkah.com',
            'link' => $report
        ];
        // get env value 
        $env = env('MAIL_REPORT');
        \Mail::to($env)->send(new \App\Mail\WmsReportEmail($data));
    }
}
