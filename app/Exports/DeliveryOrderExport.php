<?php

namespace App\Exports;

use App\Actions\BalanceSheet\BalanceSheetCalculationAction;
use Carbon\Carbon;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// import DeliveryOrder model
use App\Models\DeliveryOrder;

class DeliveryOrderExport implements FromView, ShouldAutoSize
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
        $all = DeliveryOrder::filterResource($request, [
            'purchase_date',
            'pick_up_date',
            'supplier.name',
            'transaction_type',
            'status'
        ], [])
            ->with(['supplier', 'driver', 'vehicle', 'delivery_order_detail', 'delivery_order_detail.stock', 'delivery_order_detail.stock.product'])
            // ->whereDate('created_at', Carbon::today())
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'));
            if($request->has('start_date') && $request->has('end_date')){
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $all = $all->whereBetween('purchase_date', [$start_date, $end_date]);
            }

        $data = $all->get();
            
        $title = 'Data Pembelian';
        return view('pages.backoffice.delivery_order.export', compact('data', 'title'));
    }
}
