<?php

namespace App\Exports;

use App\Models\Closing;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClosingExport implements FromView, ShouldAutoSize
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

        $all = Closing::filterResource($request, [
            'created_at',
            'cust_has_not_paid',
            'main_balance',
            'receivables',
            'debt',
            'bri_balance',
            'business_balance',
            'shop_debt',
            'shop_capital',
            'who_create'
        ], [])
            ->with(['closing_detail', 'closing_detail.customer'])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('date', [$start_date, $end_date]);
        }

        $data = $all->get();
        $title = 'Data Rekap';
        return view('pages.backoffice.closing.export', compact('data', 'title'));
    }
}
