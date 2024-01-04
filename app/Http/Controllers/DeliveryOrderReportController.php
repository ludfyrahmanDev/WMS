<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryOrderReportController extends Controller
{
    public function index(Request $request)
    {
        $data = DeliveryOrder::filterResource($request, [
            'purchase_date',
            'pick_up_date',
            'supplier.name',
            'transaction_type',
            'status'
        ], [])
            ->with('supplier')
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));

        $title = 'Data Pembelian';
        $route = 'delivery_order';

        return view('pages.backoffice.delivery_order.index', compact('data', 'title', 'route'));
    }
}
