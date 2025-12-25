<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\Master\SupplierStoreRequest;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $data = Supplier::filterResource($request, [
            'npwp',
            'name',
            'address',
            'phone',
            'pic'
        ], [])
        ->withCount('deliveryOrder')
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));

        $title = 'Data Supplier';
        $route = 'supplier';

        return view('pages.backoffice.supplier.index', compact('data', 'title', 'route'));
    }

    public function create()
    {
        $data = (object)[
            'npwp'      => '',
            'nik'       => '',
            'name'      => '',
            'address'   => '',
            'phone'     => '',
            'pic'       => ''
        ];

        $title = 'Data Supplier';
        $route = route('supplier.store');
        $type = 'create';

        return view('pages.backoffice.supplier._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(SupplierStoreRequest $request)
    {
        try {
            $supplier           = new Supplier();
            $supplier->npwp     = $request->npwp;
            $supplier->nik      = $request->nik;
            $supplier->name     = $request->name;
            $supplier->address  = $request->address;
            $supplier->phone    = $request->phone;
            $supplier->pic      = $request->pic;
            $supplier->save();

            return redirect('supplier')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }

    public function edit(Supplier $supplier)
    {
        $data   = $supplier;
        $title  = 'Data Supplier';
        $route  = route('supplier.update', $supplier);
        $type   = 'edit';

        return view('pages.backoffice.supplier._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(SupplierStoreRequest $request, Supplier $supplier)
    {
        try {
            $supplier->npwp     = $request->npwp;
            $supplier->nik      = $request->nik;
            $supplier->name     = $request->name;
            $supplier->address  = $request->address;
            $supplier->phone    = $request->phone;
            $supplier->pic      = $request->pic;
            $supplier->save();

            return redirect('supplier')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
        }
    }

    public function show(Supplier $supplier)
    {
        // Load supplier with delivery orders and their details
        $supplier->load(['deliveryOrder' => function($query) {
            $query->with(['delivery_order_detail.stock'])
                  ->orderBy('purchase_date', 'desc');
        }]);

        // Calculate totals for each delivery order
        $deliveryOrders = $supplier->deliveryOrder->map(function($do) {
            $totalQty = $do->delivery_order_detail->sum('purchase_amount');
            $totalPrice = $do->delivery_order_detail->sum(function($detail) {
                return $detail->stock ? ($detail->stock->price_kg * $detail->purchase_amount) : 0;
            });

            return [
                'id' => $do->id,
                'purchase_date' => $do->purchase_date,
                'total_qty' => $totalQty,
                'total_price' => $totalPrice,
            ];
        });

        $title = 'Detail Supplier';
        $route = 'supplier';

        return view('pages.backoffice.supplier.show', compact('supplier', 'deliveryOrders', 'title', 'route'));
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();

            return redirect('supplier')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!'.$th->getMessage());
        }
    }
}
