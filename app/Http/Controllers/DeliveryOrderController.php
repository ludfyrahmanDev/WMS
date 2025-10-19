<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderDetail;
use App\Http\Requests\Transaksi\DeliveryOrderStoreRequest;
use App\Exports\DeliveryOrderExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\DeliveryOrderQuota;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryOrderPayment;
use App\Models\Kas;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderController extends Controller
{
    public function index(Request $request)
    {
        $cv_id = session('cv_id');
        $all = DeliveryOrder::filterResource($request, [
            'purchase_date',
            'pick_up_date',
            'supplier.name',
            'transaction_type',
            'status'
        ], [])
            ->with('supplier')
            ->when($request->has('cv_id'), function ($query) use ($cv_id, $request) {
                $query->where('cv_id', $request->cv_id  ?? $cv_id);
            })
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('purchase_date', [$start_date, $end_date]);
        }
        $total = $all->get()->sum('grand_total');
        $completed = $all->get()->sum(function ($item) {
            return $item->delivery_order_quota_detail->sum('subtotal');
        });
        $inCompleted = $total - $completed;
        $data = $all->paginate($request->get('per_page', 10));
        $title = 'Data Pembelian';
        $route = 'delivery_order';
        $request = $request->toArray();
        return view('pages.backoffice.delivery_order.index', compact('data', 'request', 'title', 'route', 'request', 'completed', 'total', 'inCompleted'));
    }

    public function create()
    {
        $data['header'] = (object)[
            'purchase_date' => null,
            'pick_up_date' => null,
            'supplier_id' => null,
            'transaction_type' => null,
            'grand_total' => null,
            'notes' => null,
            'total_payment' => null
        ];

        // Membuat instance dari model DeliveryOrder
        $deliveryOrder = new DeliveryOrder;

        $data['supplier'] = $deliveryOrder->getSupplier();
        $data['product'] = $deliveryOrder->getProduct();

        $title = 'Data Pembelian';
        $route = route('delivery_order.store');
        $type = 'create';

        return view('pages.backoffice.delivery_order._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(DeliveryOrderStoreRequest $request)
    {
        $user = auth()->user();

        try {
            //cek saldo
            DB::beginTransaction();
            $saldo = new SpendingController();

            $cekSaldo = $saldo->saldo($request);

            // insert Table Delivery order 
            $delivery_order = new DeliveryOrder();
            $delivery_order->purchase_date = $request->tanggal_pembelian;
            // $delivery_order->pick_up_date = $request->tanggal_pengambilan;
            $delivery_order->supplier_id = $request->supplier ?? null;
            $delivery_order->grand_total = curencyToInteger($request->grand_total);
            $delivery_order->total_payment = curencyToInteger($request->total_bayar);
            // $delivery_order->status = 'In Progress';
            $delivery_order->status = 'Completed'; // 'In Progress', 'On Progress', 'Completed
            $delivery_order->who_create = $user['name'];
            $delivery_order->who_update = $user['name'];
            $delivery_order->transaction_type = $request->tipe_pembelian;
            $delivery_order->notes = $request->catatan;
            $delivery_order->cv_id = session('cv_id');
            $delivery_order->save();

            // Handle kas entry logic
            $this->handleKasEntry($delivery_order, $request->tipe_pembelian, $user['name']);

            //insert Table Delivery Order Detail
            $totalDataProduk = COUNT($request->produk_id);

            for ($i = 0; $i < $totalDataProduk; $i++) {

                $orderQuota                      = new DeliveryOrderQuota();
                $orderQuota->delivery_order_id   = $delivery_order->id;
                $orderQuota->purchase_amount     = $request->jumlah_qty[$i];
                $orderQuota->subtotal            = curencyToInteger($request->subtotal_produk[$i]);
                $orderQuota->product_id          = $request->produk_id[$i];
                $orderQuota->purchase_date       = $request->tanggal_pembelian;
                $orderQuota->price_kg            = curencyToInteger($request->hargaKG[$i]);
                $orderQuota->first_stock         = $request->jumlah_qty[$i];
                $orderQuota->stock_in_use        = 0;
                $orderQuota->last_stock          = $request->jumlah_qty[$i];
                $orderQuota->created_at          = Carbon::now();
                $orderQuota->save();
            }
            DB::commit();

            return redirect(route('delivery_order.index'))->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            // var_dump($th->getMessage());
            // die;
            return back()->with('failed', 'Gagal menambah data!' . $th->getMessage());
        }
    }

    public function destroy(DeliveryOrder $delivery_order)
    {
        try {
            $deliveryOrderDetails  = $delivery_order->delivery_order_detail;

            $delivery_order->delivery_order_detail()->delete();

            foreach ($deliveryOrderDetails as $detail) {
                $detail->stock()->delete();
            }

            $delivery_order->delete();

            return  redirect('delivery_order')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return redirect('delivery_order')->with('failed', 'Gagal menghapus data!' . $th->getMessage());
        }
    }

    public function edit(DeliveryOrder $delivery_order)
    {
        $deliveryOrder = new DeliveryOrder;
        $delivery_order->load('delivery_order_quota');
        // $delivery_order->load('delivery_order_detail.stock');
        // $delivery_order->load('delivery_order_detail.stock.product');

        $data['supplier'] = $deliveryOrder->getSupplier();
        $data['product'] = $deliveryOrder->getProduct();
        $data['header'] = $delivery_order;
        $data['detail'] = $delivery_order->delivery_order_quota;

        $title = 'Data Pembelian';
        $route = route('delivery_order.update', $delivery_order);
        $type = 'edit';

        return view('pages.backoffice.delivery_order._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(DeliveryOrderStoreRequest $request, DeliveryOrder $delivery_order)
    {
        $user = auth()->user();
        try {
            if ($request->mode == 'konfirmasi lunas') {

                if (intval($delivery_order->grand_total) != intval($delivery_order->total_payment)) {
                    return back()->with('failed', 'Gagal, Total Bayar belum sesuai dengan Grand Total!');
                } else {
                    $delivery_order->status = 'Completed';
                    $delivery_order->who_update = $user['name'];
                    $delivery_order->save();

                    return redirect(route('delivery_order.index'))->with('success', 'Berhasil update data!');
                }

                return false;
            } else if ($request->mode == 'angsuran') {
                //cek saldo
                $saldo = new SpendingController();

                $cekSaldo = $saldo->saldo($request);

                if (intval(curencyToInteger($request->angsuran)) > intval($cekSaldo)) {
                    return back()->with('failed', 'Gagal, saldo tidak cukup!');
                }

                if ((intval($delivery_order->total_payment) + intval(curencyToInteger($request->angsuran))) > intval($delivery_order->grand_total)) {
                    return back()->with('failed', 'Gagal, Total Bayar melebihi dari Grand Total!');
                }

                $delivery_order->total_payment = intval($delivery_order->total_payment) + intval(curencyToInteger($request->angsuran));
                $delivery_order->who_update = $user['name'];
                $delivery_order->notes = $request->catatan;
                $delivery_order->save();

                return redirect(route('delivery_order.index'))->with('success', 'Berhasil update data!');
                return false;
            }

            if (intval(curencyToInteger($request->total_bayar)) > intval(curencyToInteger($request->grand_total))) {
                return back()->with('failed', 'Gagal, Total Bayar melebihi dari Grand Total!');
            }

            //cek saldo
            $saldo = new SpendingController();

            $cekSaldo = $saldo->saldo($request);

            if (intval(curencyToInteger($request->total_bayar)) > intval($cekSaldo)) {
                return back()->with('failed', 'Gagal, saldo tidak cukup!');
            }

            // update Table Delivery order 
            $delivery_order->purchase_date = $request->tanggal_pembelian;
            // $delivery_order->pick_up_date = $request->tanggal_pengambilan;
            $delivery_order->supplier_id = $request->supplier;
            $delivery_order->grand_total = curencyToInteger($request->grand_total);
            $delivery_order->total_payment = curencyToInteger($request->total_bayar);

            if ($request->mode != null) {
                $delivery_order->status = 'On Progress';
            } else {
                $delivery_order->status = 'In Progress';
            }

            $delivery_order->who_update = $user['name'];
            $delivery_order->transaction_type = $request->tipe_pembelian;
            $delivery_order->notes = $request->catatan;
            $delivery_order->save();

            //delete Delivery Order Detail dan Stock By ID DO
            $deliveryOrderDetails  = $delivery_order->delivery_order_detail;

            foreach ($deliveryOrderDetails as $detail) {
                $detail->delete();

                $detail->stock()->delete();
            }

            //insert Table Delivery Order Detail
            $totalDataProduk = COUNT($request->produk_id);


            if ($request->mode != null) {
                return redirect(route('delivery_order.index'))->with('success', 'Berhasil konfirmasi data!');
            } else {
                return redirect(route('delivery_order.edit', $delivery_order->id))->with('success', 'Berhasil mengubah data!');
            }
        } catch (\Throwable $th) {
            if ($request->mode == 'angsuran') {
                return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
            }
            if ($request->mode != null) {
                return back()->with('failed', 'Gagal konfirmasi data!' . $th->getMessage());
            } else {
                return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
            }
        }
    }

    public function show(DeliveryOrder $delivery_order)
    {
        $deliveryOrder = new DeliveryOrder;
        $delivery_order->load('delivery_order_quota');
        $delivery_order->load('delivery_order_quota.product');
        $delivery_order->load('delivery_order_payment');
        $delivery_order->load('delivery_order_quota_detail');
        $delivery_order->load('delivery_order_quota_detail.stock');
        $delivery_order->load('delivery_order_quota_detail.stock.product');
        $data['supplier'] = $deliveryOrder->getSupplier();
        $data['product'] = $deliveryOrder->getProduct();
        // Empty arrays for removed driver and vehicle fields
        $data['driver'] = [];
        $data['vehicle'] = [];
        $data['header'] = $delivery_order;
        $data['detail'] = $delivery_order->delivery_order_quota;
        $data['payment'] = $delivery_order->delivery_order_payment->sum('amount');
        $data['payment_detail'] = $delivery_order->delivery_order_quota_detail;
        $title = 'Data Pembelian';
        $route = route('delivery_order.update', $delivery_order);
        $type = 'view';


        $routeQuota = route('delivery_order.add-quota', $delivery_order);


        return view('pages.backoffice.delivery_order._view', compact('data', 'title', 'route', 'type','routeQuota'));
    }

    public function addQuota(Request $request, DeliveryOrder $delivery_order){ 
        $totalDataProduk = COUNT($request->produk_id);
        try {
            DB::beginTransaction();
            for ($i = 0; $i < $totalDataProduk; $i++) {
                $deliveryOrderQuota = DeliveryOrderQuota::where('delivery_order_id', $delivery_order->id)->where('product_id', $request->produk_id[$i])->first();
                $stock = new Stock();
                $stock->product_id = $request->produk_id[$i];
                $stock->purchase_date = $request->tanggal_pengambilan;
                $stock->is_active = 1;
                $stock->price_kg = $deliveryOrderQuota->price_kg;
                $stock->first_stock = $request->jumlah_qty[$i];
                $stock->stock_in_use = 0;
                $stock->last_stock   = $request->jumlah_qty[$i];
                $stock->save();

                $saldo = new SpendingController();
                $cekSaldo = $saldo->saldo($request);
                $total = array_sum($request->subtotal);
                if (intval($total) > intval($cekSaldo)) {
                    return back()->with('failed', 'Gagal, saldo tidak cukup!');
                }

                if (intval(curencyToInteger($total)) > intval(curencyToInteger($delivery_order->grand_total))) {
                    return back()->with('failed', 'Gagal, Total Bayar melebihi dari Grand Total!');
                }

                $delivery_order_detail = new DeliveryOrderDetail();
                $delivery_order_detail->delivery_order_id = $delivery_order->id;
                $delivery_order_detail->no_sj = $request->no_sj[$i];
                $delivery_order_detail->no_faktur = $request->no_faktur[$i];
                $delivery_order_detail->stock_id = $stock->id;
                $delivery_order_detail->purchase_amount = $request->jumlah_qty[$i];
                $delivery_order_detail->subtotal = curencyToInteger($request->jumlah_qty[$i] * $deliveryOrderQuota->price_kg);
                $delivery_order_detail->save();

                $deliveryOrderPayment = new DeliveryOrderPayment();
                $deliveryOrderPayment->delivery_order_id = $delivery_order->id;
                $deliveryOrderPayment->amount = $request->jumlah_qty[$i] * $deliveryOrderQuota->price_kg;
                $deliveryOrderPayment->created_at = Carbon::now();
                $deliveryOrderPayment->save();

                $kasEntry = new Kas();
                $kasEntry->transaction_type = 'kredit';
                $kasEntry->amount = $request->jumlah_qty[$i] * $deliveryOrderQuota->price_kg;
                $kasEntry->description = "Pembelian barang dari supplier {$delivery_order->supplier->name} - DO #{$delivery_order->id}";
                $kasEntry->delivery_order_id = $delivery_order->id;
                $kasEntry->cv_id = $delivery_order->cv_id;
                $kasEntry->who_create = auth()->user()['name'];
                $kasEntry->who_update = auth()->user()['name'];
                $kasEntry->save();

                $kas = new Kas();

            }
            DB::commit();
            return redirect(route('delivery_order.index'))->with('success', 'Berhasil Tambah data pengambilan!');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
        }
    }

    public function export(Request $request)
    {
        $name = 'Data Pembelian - ' . date('Y-m-d');
        $fileName = $name . '.xlsx';
        Excel::store(new DeliveryOrderExport($request), 'public/excel/' . $fileName);
        return Excel::download(new DeliveryOrderExport($request), $fileName);
    }
    public function exportPdf(Request $request)
    {
        $all = DeliveryOrder::filterResource($request, [
            'purchase_date',
            'pick_up_date',
            'supplier.name',
            'transaction_type',
            'status'
        ], [])
            ->with(['supplier', 'delivery_order_detail'])
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('purchase_date', [$start_date, $end_date]);
        }

        $data = $all->get();
        $title = 'Data Pembelian';
        $pdf = \PDF::loadView('pages.backoffice.delivery_order.export', compact('data', 'title'))->setPaper('a4', 'landscape');;
        $name = 'Laporan Pembelian';
        // show preview pdf
        return $pdf->download("$name.pdf");
    }

    /**
     * Handle kas entry for delivery order
     */
    private function handleKasEntry(DeliveryOrder $deliveryOrder, string $transactionType, string $userName)
    {
        // For "Kontan" (cash) transactions, create immediate debit entry
        if ($transactionType === 'Kontan') {
            Kas::create([
                'transaction_type' => 'kredit',
                'amount' => $deliveryOrder->grand_total,
                'description' => "Pembelian kontan dari supplier {$deliveryOrder->supplier->name} - DO #{$deliveryOrder->id}",
                'delivery_order_id' => $deliveryOrder->id,
                'cv_id' => $deliveryOrder->cv_id,
                'who_create' => $userName,
                'who_update' => $userName
            ]);
        }
        // For "Tempo Panjang" (credit) transactions, kas entry will be created when payment is made
        // This will be handled in the payment processing method
    }
}
