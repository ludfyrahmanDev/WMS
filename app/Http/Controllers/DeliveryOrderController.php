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

class DeliveryOrderController extends Controller
{
    public function index(Request $request)
    {
        $all = DeliveryOrder::filterResource($request, [
            'purchase_date',
            'pick_up_date',
            'supplier.name',
            'transaction_type',
            'status'
        ], [])
            ->with('supplier')
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('purchase_date', [$start_date, $end_date]);
        }
        $total = $all->get()->sum('grand_total');
        $completed = $all->get()->sum('total_payment');
        $inCompleted = $all->get()->where('status', '!=', 'Completed')->sum(function ($item) {
            return $item->grand_total - $item->total_payment;
        });
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
            'driver_id' => null,
            'vehicle_id' => null,
            'transaction_type' => null,
            'grand_total' => null,
            'notes' => null,
            'total_payment' => null
        ];

        // Membuat instance dari model DeliveryOrder
        $deliveryOrder = new DeliveryOrder;

        $data['supplier'] = $deliveryOrder->getSupplier();
        $data['driver'] = $deliveryOrder->getDriver();
        $data['vehicle'] = $deliveryOrder->getVehicle();
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

            // if (intval($request->total_bayar) > intval($cekSaldo)) {
            //     return back()->with('failed', 'Gagal, saldo tidak cukup!');
            // }

            // if (intval(curencyToInteger($request->total_bayar)) > intval(curencyToInteger($request->grand_total))) {
            //     return back()->with('failed', 'Gagal, Total Bayar melebihi dari Grand Total!');
            // }

            // insert Table Delivery order 
            $delivery_order = new DeliveryOrder();
            $delivery_order->purchase_date = $request->tanggal_pembelian;
            // $delivery_order->pick_up_date = $request->tanggal_pengambilan;
            $delivery_order->supplier_id = $request->supplier;
            $delivery_order->driver_id = $request->driver;
            $delivery_order->vehicle_id = $request->kendaraan;
            $delivery_order->grand_total = curencyToInteger($request->grand_total);
            $delivery_order->total_payment = curencyToInteger($request->total_bayar);
            // $delivery_order->status = 'In Progress';
            $delivery_order->status = 'Completed'; // 'In Progress', 'On Progress', 'Completed
            $delivery_order->who_create = $user['name'];
            $delivery_order->who_update = $user['name'];
            $delivery_order->transaction_type = $request->tipe_pembelian;
            $delivery_order->notes = $request->catatan;
            $delivery_order->save();

            //insert Table Delivery Order Detail
            $totalDataProduk = COUNT($request->produk_id);

            for ($i = 0; $i < $totalDataProduk; $i++) {
                // 'delivery_order_id',
                // 'purchase_amount',
                // 'subtotal',
                // 'product_id',
                // 'purchase_date',
                // 'price_kg',
                // 'first_stock',
                // 'stock_in_use',
                // 'last_stock'
                

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
                // $stock = new Stock();
                // $stock->product_id = $request->produk_id[$i];
                // $stock->purchase_date = $request->tanggal_pembelian;
                // $stock->is_active = 0;
                // $stock->price_kg = curencyToInteger($request->hargaKG[$i]);
                // $stock->first_stock = $request->jumlah_qty[$i];
                // $stock->stock_in_use = 0;
                // $stock->last_stock   = $request->jumlah_qty[$i];
                // $stock->save();

                // $delivery_order_detail = new DeliveryOrderDetail();
                // $delivery_order_detail->delivery_order_id = $delivery_order->id;
                // $delivery_order_detail->stock_id = $stock->id;
                // $delivery_order_detail->purchase_amount = $request->jumlah_qty[$i];
                // $delivery_order_detail->subtotal = curencyToInteger($request->subtotal_produk[$i]);
                // $delivery_order_detail->save();
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
        $data['driver'] = $deliveryOrder->getDriver();
        $data['vehicle'] = $deliveryOrder->getVehicle();
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
            $delivery_order->driver_id = $request->driver;
            $delivery_order->vehicle_id = $request->kendaraan;
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
        // $delivery_order->load('delivery_order_quota_detail.product');
        $data['supplier'] = $deliveryOrder->getSupplier();
        $data['driver'] = $deliveryOrder->getDriver();
        $data['vehicle'] = $deliveryOrder->getVehicle();
        $data['product'] = $deliveryOrder->getProduct();
        $data['header'] = $delivery_order;
        $data['detail'] = $delivery_order->delivery_order_quota;
        $data['payment'] = $delivery_order->delivery_order_payment->sum('amount');
        $data['payment_detail'] = $delivery_order->delivery_order_payment;
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
                $delivery_order_detail->stock_id = $stock->id;
                $delivery_order_detail->purchase_amount = $request->jumlah_qty[$i];
                $delivery_order_detail->subtotal = curencyToInteger($deliveryOrderQuota->subtotal);
                $delivery_order_detail->save();

                $deliveryOrderPayment = new DeliveryOrderPayment();
                $deliveryOrderPayment->delivery_order_id = $delivery_order->id;
                $deliveryOrderPayment->amount = $request->jumlah_qty[$i] * $deliveryOrderQuota->price_kg;
                $deliveryOrderPayment->created_at = Carbon::now();
                $deliveryOrderPayment->save();
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
            ->with(['supplier', 'vehicle', 'delivery_order_detail'])
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
}
