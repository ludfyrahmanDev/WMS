<?php

namespace App\Http\Controllers;

use App\Exports\ClosingExport;
use App\Models\Closing;
use Illuminate\Http\Request;
use App\Models\ClosingDetail;
use Maatwebsite\Excel\Facades\Excel;

class ClosingController extends Controller
{

    public function index(Request $request)
    {
        $all = Closing::filterResource($request, [
            'created_at',
            'cust_has_not_paid',
            'main_balance',
            'receivables',
            'debt',
            // 'bri_balance',
            // 'business_balance',
            'shop_receivables',
            'shop_capital',
            'who_create'
        ], [])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('date', [$start_date, $end_date]);
        }
        $data = $all->paginate($request->get('per_page', 10));

        $cekDataDateNow = Closing::cekDataDateNow();

        $title = 'Data Closing';
        $route = route('closing.store');
        $request = $request->toArray();

        return view('pages.backoffice.closing.index', compact('data', 'title', 'route', 'request', 'cekDataDateNow'));
    }

    public function store(Request $request, Closing $closing)
    {
        $user = auth()->user();

        try {
            //get customer belum bayar
            $custHasNotPaid = Closing::getCustHasNotPaid();
            $totalCustHasNotPaid = Closing::getTotalCustHasNotPaid();
            //get saldo, hutang
            $saldo = new SpendingController();
            $totalSaldo = $saldo->saldo($request);
            //get hutang
            $hutang = Closing::getHutang();

            $closing->cust_has_not_paid = $totalCustHasNotPaid == null ? 0 : $totalCustHasNotPaid;
            $closing->date = date('Y-m-d');
            $closing->main_balance = $totalSaldo;
            $closing->receivables = $totalCustHasNotPaid == null ? 0 : $totalCustHasNotPaid;
            $closing->debt = $hutang == null ? 0 : $hutang;
            // $closing->bri_balance = $request->saldo_bri;
            // $closing->business_balance = $request->saldo_bisnis;
            $closing->shop_receivables = intval(curencyToInteger($request->piutang_toko));
            $closing->shop_capital = intval(curencyToInteger($request->modal_toko));
            $closing->who_create = $user['name'];
            $closing->save();

            if (COUNT($custHasNotPaid) > 0) {
                foreach ($custHasNotPaid as $key => $value) {
                    $closingDetail = new ClosingDetail();
                    $closingDetail->customer_id = $value->customer_id;
                    $closingDetail->nominal = $value->nominal;
                    $closingDetail->closing_id = $closing->id;
                    $closingDetail->save();
                }
            }

            return redirect(route('closing.index'))->with('success', 'Berhasil menyimpan data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal, menyimpan data!' . $th->getMessage());
        }
    }

    public function getDetailClosingByID(Request $request)
    {
        $closing_id = $request->input('closing_id');

        $closingDetail = ClosingDetail::getClosingDetailByIDClosing($closing_id);

        return response()->json($closingDetail);
    }

    public function export(Request $request)
    {
        $name = 'Data Rekap - ' . date('Y-m-d');
        $fileName = $name . '.xlsx';
        Excel::store(new ClosingExport($request), 'public/excel/' . $fileName);
        return Excel::download(new ClosingExport($request), $fileName);
    }

    public function exportPdf(Request $request)
    {
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
        $pdf = \PDF::loadView('pages.backoffice.closing.export', compact('data', 'title'))->setPaper('a4', 'landscape');;
        $name = 'Laporan Rekap';
        // show preview pdf
        return $pdf->download("$name.pdf");
    }
}
