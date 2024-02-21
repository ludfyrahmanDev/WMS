<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Spending;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
// import Spending model
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Actions\BalanceSheet\BalanceSheetCalculationAction;

class SpendingExport implements FromView, ShouldAutoSize
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
        $all = Spending::filterResource($request, [
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
        // where by this day
        ->whereDate('created_at', Carbon::today())
        ->orderBy($request->get('sort_by', 'date'), $request->get('order', 'desc'))
        ->orderBy($request->get('sort_by', 'spending_category_id'), $request->get('order', 'asc'))
        ->orderBy($request->get('sort_by', 'mutation'), $request->get('order', 'asc'))
        ->orderBy($request->get('sort_by', 'payment_method'), $request->get('order', 'asc'));
        if($request->has('start_date') && $request->has('end_date')){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('created_at', [$start_date, $end_date]);
        }

        $data = $all->get();
        $title = 'Data Pengeluaran';
        return view('pages.backoffice.spending.export', compact('data', 'title'));
    }
}
