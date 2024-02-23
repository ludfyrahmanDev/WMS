<?php

namespace App\Exports;

use App\Actions\BalanceSheet\BalanceSheetCalculationAction;
use Carbon\Carbon;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// import VehicleService model
use App\Models\VehicleService;

class VehicleServiceExport implements FromView, ShouldAutoSize
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
        $all = VehicleService::filterResource($request, [
            'date',
            'DESCRIPTION',
            'amount_of_expenditure'
        ], [])
            ->with(['vehicleServiceDetail', 'vehicleServiceDetail.spendingCategory', 'vehicle'])
            ->whereDate('created_at', Carbon::today())
            ->orderBy($request->get('sort_by', 'date'), $request->get('order', 'desc'));
            if($request->has('start_date') && $request->has('end_date')){
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $all = $all->whereBetween('date', [$start_date, $end_date]);
            }

        $data = $all->get();
        $title = 'Data Servis Kendaraan';
        return view('pages.backoffice.vehicle_service.export', compact('data', 'title'));
    }
}
