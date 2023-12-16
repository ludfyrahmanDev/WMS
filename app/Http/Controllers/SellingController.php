<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Selling;
use App\Models\SellingDetail;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Product;
use App\Http\Requests\Transaksi\SellingStoreRequest;

class SellingController extends Controller
{
    public function index(Request $request)
    {
        $data = Selling::with('customer', 'driver')
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
        $title = 'Data Penjualan';
        $route = 'selling';
        return view('pages.backoffice.selling.index', compact('data', 'title', 'route'));
    }

    public function create()
    {
        $customer = Customer::all();
        $driver = Driver::all();
        $vehicle = Vehicle::all();
        $product = Product::all();
        $data = (object)[
            'date' => '',
            'customer' => '',
            'vehicle' => '',
            'driver' => '',
            'driver_pocket_money' => '',
            'net_profit' => '',
            'purchasing_method' => '',
            'notes' => '',
            'status' => '',
            'payment_type' => ''
        ];

        $title = 'Data Penjualan';
        $route = route('selling.store');
        $type = 'create';

        return view('pages.backoffice.selling._form', compact('data', 'title', 'route', 'type', 'customer', 'driver', 'vehicle', 'product'));
    }

    public function store(SellingStoreRequest $request)
    {
        $user = auth()->user();

        try {
            // insert Table Selling
            $selling = new Selling();
            $selling->date = $request->tgl_jual;
            $selling->customer_id = $request->customer;
            $selling->vehicle_id = $request->supplier;
            $selling->driver_id = $request->driver;
            $selling->vehicle_id = $request->kendaraan;
            $selling->drivers_pocket_money = $request->uang_saku;
            $selling->purchasing_method = $request->tipe_pembelian;
            $selling->payment_type = $request->tipe_pembayaran;
            $selling->notes = $request->catatan;
            $selling->status = $request->catatan;
            $selling->grand_total = $request->grand_total;
            $selling->total_payment = $request->total_bayar;
            $selling->net_profit = $request->laba_bersih;
            $selling->status = 'in_progress';
            $selling->created_by = $user['id'];
            $selling->updated_by = $user['id'];
            $selling->save();

            //insert Table Selling Detail
            $totalDataProduk = COUNT($request->produk_id);

            for ($i = 0; $i < $totalDataProduk; $i++) {
                $selling_detail = new SellingDetail();
                $selling_detail->selling_id = $selling->id;
                $selling_detail->product_id = $request->produk_id[$i];
                $selling_detail->qty = $request->jumlah_qty[$i];
                $selling_detail->price = $request->harga_awal[$i];
                $selling_detail->price_sell = $request->harga_jual[$i];
                $selling_detail->subtotal = $request->subtotal_produk[$i];
                $selling_detail->save();
            }

            return redirect(route('selling.index'))->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage() . " at line " . $th->getLine();
            var_dump($errorMessage);
            die;
            return back()->with('failed', $errorMessage);
        }
    }

    public function edit(Selling $Selling)
    {
        $selling = new Selling;

        $selling->load('selling_detail.product');

        $data['customer']   = $selling->getCustomer();
        $data['driver']     = $selling->getDriver();
        $data['vehicle']    = $selling->getVehicle();
        $data['product']    = $selling->getProduct();
        $data['header']     = $Selling;
        $data['detail']     = $Selling->delivery_order_detail;

        $title = 'Data Penjualan';
        $route = route('selling.update', $Selling);
        $type = 'edit';

        return view('pages.backoffice.selling._form', compact('data', 'title', 'route', 'type'));
    }
}
