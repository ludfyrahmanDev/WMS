<?php

namespace App\Http\Controllers;

use App\Http\Requests\Master\TaxStoreRequest;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    //

    public function index(Request $request)
    {
        $data = Tax::with('cv')
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
        $title = 'Data Pajak';
        $route = 'tax';

        return view('pages.backoffice.tax.index', compact('data', 'title', 'route'));
    }

    public function create()
    {
        $tax = Tax::get();

        $data = (object)[
            'percentage' => ''
        ];

        $title = 'Data Pajak';
        $route = route('tax.store');
        $type = 'create';

        return view('pages.backoffice.tax._form', compact('data', 'title', 'route', 'type', 'tax'));
    }

    public function store(TaxStoreRequest $request)
    {
        session(['cv_id' => 1]);

        try {
            $tax = new Tax();
            $tax->cv_id = session('cv_id');
            $tax->percentage = $request->percentage;
            $tax->save();

            if ($tax) {
                return redirect('tax')->with('success', 'Berhasil menambah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data! ' . $th->getMessage());
        }
    }

     public function edit(tax $tax)
    {

        $data = $tax;
        $title = 'Data Pajak';
        $route = route('tax.update', $tax);
        $type = 'edit';

        return view('pages.backoffice.tax._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(TaxStoreRequest $request, tax $tax)
    {
        try {
            $tax->percentage = $request->percentage;
            $tax->save();

            if ($tax) {
                return redirect('tax')->with('success', 'Berhasil mengubah data!');
            } else {
                return back()->with('failed', 'Gagal mengubah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    public function destroy(Tax $tax)
    {
        try {
            $tax->delete();

            return redirect('tax')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!' . $th->getMessage());
        }
    }
}
