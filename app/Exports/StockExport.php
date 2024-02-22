<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Stock;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
// import Spending model
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Actions\BalanceSheet\BalanceSheetCalculationAction;

class StockExport implements FromView, ShouldAutoSize
{
    use Exportable;

    protected  $request;

    function __construct($request)
    {
        $this->request    = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $all = Stock::filterResource($request, [
            'product.product',
            'purchase_date',
            'first_stock',
            'stock_in_use',
            'last_stock'
        ], [])
            ->with('product')
            ->where('is_active', 1)
            // ->where('last_stock', '>',  0)
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'))
            ->orderBy($request->get('sort_by', 'last_stock'), $request->get('order', 'asc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('purchase_date', [$start_date, $end_date]);
        }

        $data = $all->get();
        $title = 'Data Stok';
        return view('pages.backoffice.stock.export', compact('data', 'title'));
    }
}
