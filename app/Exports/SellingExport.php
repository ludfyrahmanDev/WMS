<?php

namespace App\Exports;

use App\Actions\BalanceSheet\BalanceSheetCalculationAction;
use Carbon\Carbon;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// import DeliveryOrder model
use App\Models\Selling;

class SellingExport implements FromView, ShouldAutoSize
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
        $all = Selling::with(['customer', 'driver','selling_detail','selling_detail.stock','selling_detail.stock.product'])
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('created_at', [$start_date, $end_date]);
        }

        $data = $all->get();
        $title = 'Data Penjualan';
        return view('pages.backoffice.selling.export', compact('data', 'title'));
    }
}
