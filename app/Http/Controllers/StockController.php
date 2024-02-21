<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Stock;
use App\Exports\StockExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $all = Stock::filterResource($request, [
            'product.product',
            'purchase_date',
            'first_stock',
            'stock_in_use',
            'last_stock'
        ], [])
            ->with('product')
            ->where('is_active', 1)
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'))
            ->orderBy($request->get('sort_by', 'last_stock'), $request->get('order', 'asc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('purchase_date', [$start_date, $end_date]);
        }
        // ->paginate($request->get('per_page', 10));

        $data = $all->paginate($request->get('per_page', 10));
        $title = 'Data Stok';
        $route = 'stock';
        $request = $request->toArray();

        return view('pages.backoffice.stock.index', compact('data', 'title', 'route', 'request'));
    }

    public function export(Request $request)
    {
        $name = 'Data Stok';
        $fileName = $name . '.xlsx';
        return Excel::download(new StockExport($request), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $all = Stock::filterResource($request, [
            'product.product',
            'purchase_date',
            'first_stock',
            'stock_in_use',
            'last_stock'
        ], [])
            ->with('product')
            ->where('is_active', 1)
            ->where('last_stock', '>',  0)
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'))
            ->orderBy($request->get('sort_by', 'last_stock'), $request->get('order', 'asc'));
            if ($request->has('start_date') && $request->has('end_date')) {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $all = $all->whereBetween('purchase_date', [$start_date, $end_date]);
            }

        $data = $all->get();
        $title = 'Data Stok';
        $pdf = PDF::loadView('pages.backoffice.stock.export', compact('data', 'title'))->setPaper('a4', 'landscape');;
        $name = 'Laporan Stok';
        // show preview pdf
        return $pdf->download("$name.pdf");
    }
}
