<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Selling;
use App\Models\SellingDetail;
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

    public function create(Selling $selling)
    {
        $data['customer']   = $selling->getCustomer();
        $data['driver']     = $selling->getDriver();
        $data['vehicle']    = $selling->getVehicle();
        $data['product']    = $selling->getProduct();
        
        $data['header'] = (object)[
            'date'                  => null,
            'customer_id'           => null,
            'vehicle_id'            => null,
            'driver_id'             => null,
            'driver_pocket_money'   => null,
            'net_profit'            => null,
            'purchasing_method'     => null,
            'notes'                 => null,
            'status'                => null,
            'payment_type'          => null
        ];

        $title  = 'Data Penjualan';
        $route  = route('selling.store');
        $type   = 'create';

        return view('pages.backoffice.selling._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(SellingStoreRequest $request)
    {
        $user = auth()->user();
        // var_dump($request); die;
        try {
            // insert Table Selling
            $selling                        = new Selling();
            $selling->date                  = $request->tgl_jual;
            $selling->customer_id           = $request->customer;
            $selling->vehicle_id            = $request->supplier;
            $selling->driver_id             = $request->driver;
            $selling->vehicle_id            = $request->kendaraan;
            $selling->drivers_pocket_money  = $request->uang_saku;
            $selling->purchasing_method     = $request->tipe_pembelian;
            $selling->payment_type          = $request->tipe_pembayaran;
            $selling->notes                 = $request->catatan;
            $selling->status                = $request->catatan;
            $selling->grand_total           = $request->grand_total;
            $selling->total_payment         = $request->total_bayar;
            $selling->net_profit            = $request->laba_bersih;
            $selling->status                = 'in_progress';
            $selling->created_by            = $user['name'];
            $selling->updated_by            = $user['name'];
            $selling->save();

            //insert Table Selling Detail
            $totalDataProduk = COUNT($request->produk_id);

            for ($i = 0; $i < $totalDataProduk; $i++) {
                $selling_detail = new SellingDetail();
                $selling_detail->selling_id = $selling->id;
                $selling_detail->product_id = $request->produk_id[$i];
                $selling_detail->qty        = $request->jumlah_qty[$i];
                $selling_detail->price      = $request->harga_awal[$i];
                $selling_detail->price_sell = $request->harga_jual[$i];
                $selling_detail->subtotal   = $request->subtotal_produk[$i];
                $selling_detail->save();
            }

            return redirect(route('selling.index'))->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage() . " at line " . $th->getLine();
            // var_dump($errorMessage);
            // die;
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
        $data['detail']     = $Selling->selling_detail;

        // echo json_encode($data['product']); die;

        $title = 'Data Penjualan';
        $route = route('selling.update', $Selling);
        $type = 'edit';

        return view('pages.backoffice.selling._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(SellingStoreRequest $request, Selling $selling)
    {
        $user = auth()->user();
        
        try {
            if ($request->mode == 'confirm') {
                $selling->status = 'completed';
                $selling->updated_by = $user['name'];
                $selling->save();

                return redirect(route('selling.index'))->with('success', 'Berhasil update data!');
                return false;
            }

            // insert Table Selling
            $selling->date                  = $request->tgl_jual;
            $selling->customer_id           = $request->customer;
            $selling->vehicle_id            = $request->supplier;
            $selling->driver_id             = $request->driver;
            $selling->vehicle_id            = $request->kendaraan;
            $selling->drivers_pocket_money  = $request->uang_saku;
            $selling->purchasing_method     = $request->tipe_pembelian;
            $selling->payment_type          = $request->tipe_pembayaran;
            $selling->notes                 = $request->catatan;
            $selling->status                = $request->catatan;
            $selling->grand_total           = $request->grand_total;
            $selling->total_payment         = $request->total_bayar;
            $selling->net_profit            = $request->laba_bersih;
            $selling->status                = 'in_progress';
            $selling->created_by            = $user['name'];
            $selling->updated_by            = $user['name'];
            $selling->save();

            $selling->selling_detail()->delete();

            //insert Table Selling Detail
            $totalDataProduk = COUNT($request->produk_id);

            for ($i = 0; $i < $totalDataProduk; $i++) {
                $selling_detail             = new SellingDetail();
                $selling_detail->selling_id = $selling->id;
                $selling_detail->product_id = $request->produk_id[$i];
                $selling_detail->qty        = $request->jumlah_qty[$i];
                $selling_detail->price      = $request->harga_awal[$i];
                $selling_detail->price_sell = $request->harga_jual[$i];
                $selling_detail->subtotal   = $request->subtotal_produk[$i];
                $selling_detail->save();
            }

            if ($request->mode != null) {
                return redirect(route('selling.index'))->with('success', 'Berhasil menyimpan data!');
            } else {
                return redirect(route('selling.edit', $selling->id))->with('success', 'Berhasil update data!');
            }
            return redirect(route('selling.index'))->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage() . " at line " . $th->getLine();
            // var_dump($errorMessage);
            // die;
            return back()->with('failed', 'Gagal menyimpan data, karena : ' . $errorMessage);
        }
    }

    public function destroy(Selling $selling)
    {
        try {
            $selling->selling_detail()->delete();
            $selling->delete();
            return  redirect('selling')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage() . " at line " . $th->getLine();
            return back()->with('failed', 'Gagal menghapus data, karena : ' . $errorMessage);
        }
    }

    public function show(Selling $Selling)
    {
        $selling = new Selling;

        $selling->load('selling_detail.product');

        $data['customer']   = $selling->getCustomer();
        $data['driver']     = $selling->getDriver();
        $data['vehicle']    = $selling->getVehicle();
        $data['product']    = $selling->getProduct();
        $data['header']     = $Selling;
        $data['detail']     = $Selling->selling_detail;

        // echo json_encode($data['product']); die;

        $title = 'Data Penjualan';
        $route = route('selling.update', $Selling);
        $type = 'show';

        return view('pages.backoffice.selling._view', compact('data', 'title', 'route', 'type'));
    }
}
