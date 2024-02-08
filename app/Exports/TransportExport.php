<?php

namespace App\Exports;

use App\Actions\BalanceSheet\BalanceSheetCalculationAction;
use Carbon\Carbon;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// import DeliveryOrder model
use App\Models\Transport;

class TransportExport implements FromView, ShouldAutoSize
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
        $data = Transport::with('customer', 'driver')
                ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
                ->get();
        $title = 'Data Angkutan - ' . date('Y-m-d');
        return view('pages.backoffice.transport.export', compact('data', 'title'));
    }
}
