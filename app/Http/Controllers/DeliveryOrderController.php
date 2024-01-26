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
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'));
        $total = $all->get()->sum('grand_total');
        $completed = $all->get()->where('status', 'Completed')->sum('grand_total');
        $inCompleted = $all->get()->where('status', '!=', 'Completed')->sum('grand_total');
        $data = $all->paginate($request->get('per_page', 10));

        $title = 'Data Pembelian';
        $route = 'delivery_order';
        $request = $request->toArray();

        return view('pages.backoffice.delivery_order.index', compact('data', 'title', 'route', 'request', 'completed', 'total', 'inCompleted'));
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
            if ($request->tipe_pembelian == 'Kontan') {
                $saldo = new SpendingController();

                $cekSaldo = $saldo->saldo($request);

                if (intval($request->total_bayar) > intval($cekSaldo)) {
                    return back()->with('failed', 'Gagal, saldo tidak cukup!');
                }
            }

            // insert Table Delivery order 
            $delivery_order = new DeliveryOrder();
            $delivery_order->purchase_date = $request->tanggal_pembelian;
            $delivery_order->pick_up_date = $request->tanggal_pengambilan;
            $delivery_order->supplier_id = $request->supplier;
            $delivery_order->driver_id = $request->driver;
            $delivery_order->vehicle_id = $request->kendaraan;
            $delivery_order->grand_total = $request->grand_total;
            $delivery_order->total_payment = $request->total_bayar;
            $delivery_order->status = 'In Progress';
            $delivery_order->who_create = $user['name'];
            $delivery_order->who_update = $user['name'];
            $delivery_order->transaction_type = $request->tipe_pembelian;
            $delivery_order->notes = $request->catatan;
            $delivery_order->save();

            //insert Table Delivery Order Detail
            $totalDataProduk = COUNT($request->produk_id);

            for ($i = 0; $i < $totalDataProduk; $i++) {
                $stock = new Stock();
                $stock->product_id = $request->produk_id[$i];
                $stock->purchase_date = $request->tanggal_pembelian;
                $stock->is_active = 0;
                $stock->price_kg = $request->hargaKG[$i];
                $stock->first_stock = $request->jumlah_qty[$i];
                $stock->stock_in_use = 0;
                $stock->last_stock   = $request->jumlah_qty[$i];
                $stock->save();

                $delivery_order_detail = new DeliveryOrderDetail();
                $delivery_order_detail->delivery_order_id = $delivery_order->id;
                $delivery_order_detail->stock_id = $stock->id;
                $delivery_order_detail->purchase_amount = $request->jumlah_qty[$i];
                $delivery_order_detail->subtotal = $request->subtotal_produk[$i];
                $delivery_order_detail->save();
            }

            return redirect(route('delivery_order.index'))->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            // var_dump($th->getMessage());
            // die;
            return back()->with('failed', 'Gagal menambah data!');
        }
    }

    public function destroy(DeliveryOrder $delivery_order)
    {
        try {
            $deliveryOrderDetails  = $delivery_order->delivery_order_detail;

            foreach ($deliveryOrderDetails as $detail) {
                $detail->stock()->delete();
            }

            $delivery_order->delete();

            return  redirect('delivery_order')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }

    public function edit(DeliveryOrder $delivery_order)
    {
        $deliveryOrder = new DeliveryOrder;

        $delivery_order->load('delivery_order_detail.stock');
        $delivery_order->load('delivery_order_detail.stock.product');

        $data['supplier'] = $deliveryOrder->getSupplier();
        $data['driver'] = $deliveryOrder->getDriver();
        $data['vehicle'] = $deliveryOrder->getVehicle();
        $data['product'] = $deliveryOrder->getProduct();
        $data['header'] = $delivery_order;
        $data['detail'] = $delivery_order->delivery_order_detail;

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
                $delivery_order->status = 'Completed';
                $delivery_order->who_update = $user['name'];
                $delivery_order->save();

                return redirect(route('delivery_order.index'))->with('success', 'Berhasil update data!');
                return false;
            } else if ($request->mode == 'angsuran') {
                $delivery_order->total_payment = intval($delivery_order->total_payment) + intval($request->angsuran);
                $delivery_order->who_update = $user['name'];
                $delivery_order->notes = $request->catatan;
                $delivery_order->save();

                return redirect(route('delivery_order.index'))->with('success', 'Berhasil update data!');
                return false;
            }

            //cek saldo
            if ($request->tipe_pembelian == 'Kontan') {
                $saldo = new SpendingController();

                $cekSaldo = $saldo->saldo($request);

                if (intval($request->total_bayar) > intval($cekSaldo)) {
                    return back()->with('failed', 'Gagal, saldo tidak cukup!');
                }
            }

            // update Table Delivery order 
            $delivery_order->purchase_date = $request->tanggal_pembelian;
            $delivery_order->pick_up_date = $request->tanggal_pengambilan;
            $delivery_order->supplier_id = $request->supplier;
            $delivery_order->driver_id = $request->driver;
            $delivery_order->vehicle_id = $request->kendaraan;
            $delivery_order->grand_total = $request->grand_total;
            $delivery_order->total_payment = $request->total_bayar;

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

            // $delivery_order->delivery_order_detail()->delete();
            // $delivery_order->stock()->delete();

            //insert Table Delivery Order Detail
            $totalDataProduk = COUNT($request->produk_id);

            for ($i = 0; $i < $totalDataProduk; $i++) {
                $stock = new Stock();
                $stock->product_id = $request->produk_id[$i];
                $stock->purchase_date = $request->tanggal_pembelian;

                if ($request->mode != null) {
                    $stock->is_active = 1;
                } else {
                    $stock->is_active = 0;
                }

                $stock->price_kg = $request->hargaKG[$i];
                $stock->first_stock = $request->jumlah_qty[$i];
                $stock->stock_in_use = 0;
                $stock->last_stock   = $request->jumlah_qty[$i];
                $stock->save();

                $delivery_order_detail = new DeliveryOrderDetail();
                $delivery_order_detail->delivery_order_id = $delivery_order->id;
                $delivery_order_detail->stock_id = $stock->id;
                $delivery_order_detail->purchase_amount = $request->jumlah_qty[$i];
                $delivery_order_detail->subtotal = $request->subtotal_produk[$i];
                $delivery_order_detail->save();
            }

            if ($request->mode != null) {
                return redirect(route('delivery_order.index'))->with('success', 'Berhasil konfirmasi data!');
            } else {
                return redirect(route('delivery_order.edit', $delivery_order->id))->with('success', 'Berhasil mengubah data!');
            }
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
            die;
            if ($request->mode == 'angsuran') {
                return back()->with('failed', 'Gagal mengubah data!');
            }
            if ($request->mode != null) {
                return back()->with('failed', 'Gagal konfirmasi data!');
            } else {
                return back()->with('failed', 'Gagal mengubah data!');
            }
        }
    }

    public function show(DeliveryOrder $delivery_order)
    {
        $deliveryOrder = new DeliveryOrder;

        $delivery_order->load('delivery_order_detail.stock');
        $delivery_order->load('delivery_order_detail.stock.product');

        $data['supplier'] = $deliveryOrder->getSupplier();
        $data['driver'] = $deliveryOrder->getDriver();
        $data['vehicle'] = $deliveryOrder->getVehicle();
        $data['product'] = $deliveryOrder->getProduct();
        $data['header'] = $delivery_order;
        $data['detail'] = $delivery_order->delivery_order_detail;

        $title = 'Data Pembelian';
        $route = route('delivery_order.update', $delivery_order);
        $type = 'view';

        return view('pages.backoffice.delivery_order._view', compact('data', 'title', 'route', 'type'));
    }

    public function export(Request $request)
    {
        $name = 'Data Pembelian - ' . date('Y-m-d');
        $fileName = $name . '.xlsx';
        Excel::store(new DeliveryOrderExport($request), 'public/excel/'.$fileName);
        return Excel::download(new DeliveryOrderExport($request), $fileName);
    }
    public function exportPdf(Request $request)
    {
        $data = DeliveryOrder::filterResource($request, [
            'purchase_date',
            'pick_up_date',
            'supplier.name',
            'transaction_type',
            'status'
        ], [])
            ->with(['supplier', 'vehicle', 'delivery_order_detail'])
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'))
            ->get();
        $title = 'Data Pembelian';
        $pdf = \PDF::loadView('pages.backoffice.delivery_order.export', compact('data', 'title'))->setPaper('a4', 'landscape');;
        $name = 'Laporan Pembelian';
        // show preview pdf
        return $pdf->download("$name.pdf");
    }
}
