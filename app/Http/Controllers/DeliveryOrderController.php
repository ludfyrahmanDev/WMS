<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $title = 'Data Pembelian';
        $route = 'delivery_order';

        return view('pages.backoffice.delivery_order.index', compact('data', 'title', 'route'));
    }

    public function create()
    {
        $data = (object)[
            'description' => '',
            'spending_category_id' => '',
            'payment_method' => '',
            'nominal' => ''
        ];

        $title = 'Data Pembelian';
        $route = route('delivery_order.store');
        $type = 'create';

        return view('pages.backoffice.delivery_order._form', compact('data', 'title', 'route', 'type'));
    }
}
