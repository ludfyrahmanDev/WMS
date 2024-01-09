<?php

namespace App\Http\Controllers;

use App\Models\Spending;
use Barryvdh\DomPDF\PDF;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use App\Exports\SpendingExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Transaksi\SpendingStoreRequest;

class SpendingController extends Controller
{
    public function index(Request $request)
    {
        $data = Spending::filterResource($request, [
            'date',
            'spendingCategory.spending_category',
            'mutation',
            'payment_method',
            'who_update',
        ], [])
        ->with('spendingCategory')
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
        ->paginate($request->get('per_page', 10));
        
        $title = 'Data Pengeluaran';
        $route = 'spending';
        $request = $request->toArray();

        return view('pages.backoffice.spending.index', compact('data', 'title', 'route', 'request'));
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

        $title = 'Data Pengeluaran';
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
            $spending->nominal = $request->nominal;
            $spending->save();

            return redirect('spending')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!');
        }
    }

    public function edit(Spending $spending)
    {
        $kategori = $spending->getSpendingCategory();
        $enum = PaymentMethod::asOptions();

        $data = $spending;
        $title = 'Data Pengeluaran';
        $route = route('spending.update', $spending);
        $type = 'edit';

        return view('pages.backoffice.spending._form', compact('kategori', 'enum', 'data', 'title', 'route', 'type'));
    }

    public function update (SpendingStoreRequest $request, Spending $spending)
    {
        $user = auth()->user();

        try {
            $spending->date = $request->tanggal;
            $spending->mutation = $request->mutasi;
            $spending->spending_category_id = $request->spending_category;
            $spending->who_update = $user['name'];
            $spending->description = $request->description;
            $spending->payment_method = $request->payment_method;
            $spending->nominal = $request->nominal;
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
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }

    public function export(Request $request)
    {
        $name = 'Data Pengeluaran';
        $fileName = $name . '.xlsx';
        return Excel::download(new SpendingExport($request), $fileName);
    }

    public function exportPdf(Request $request){
        $data = Spending::filterResource($request, [
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
        ->orderBy($request->get('sort_by', 'payment_method'), $request->get('order', 'asc'))
        ->get();    

        $title = 'Data Pengeluaran';
        $pdf = \PDF::loadView('pages.backoffice.spending.export', compact('data', 'title'))->setPaper('a4', 'landscape');;
        $name = 'Laporan Pengeluaran';
        // show preview pdf
        return $pdf->download("$name.pdf");
    }
}
