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
            'name',
            'address',
            'phone',
            'pic'
        ], [])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));

        $title = 'Data Supplier';
        $route = 'supplier';

        return view('pages.backoffice.supplier.index', compact('data', 'title', 'route'));
    }

    public function create()
    {
        $data = (object)[
            'name' => '',
            'address' => '',
            'phone' => '',
            'pic' => ''
        ];

        $title = 'Data Supplier';
        $route = route('supplier.store');
        $type = 'create';

        return view('pages.backoffice.supplier._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(SupplierStoreRequest $request)
    {
        try {
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->pic = $request->pic;
            $supplier->save();

            return redirect('supplier')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!');
        }
    }

    public function edit(Supplier $supplier)
    {
        $data = $supplier;
        $title = 'Data Supplier';
        $route = route('supplier.update', $supplier);
        $type = 'edit';

        return view('pages.backoffice.supplier._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(SupplierStoreRequest $request, Supplier $supplier)
    {
        try {
            $supplier->name = $request->name;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->pic = $request->pic;
            $supplier->save();

            return redirect('supplier')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
        }
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();

            return redirect('supplier')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }
}
