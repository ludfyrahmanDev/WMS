<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Selling;
use App\Http\Requests\Transaksi\SellingStoreRequest;

class SellingController extends Controller
{
    public function index(Request $request)
    {
        $data = Selling::with('customer', 'driver')
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
        $title = 'Data Penjualan';
        $route = 'selling';
        return view('pages.backoffice.selling.index', compact('data', 'title','route'));
    }

    public function create()
    {
        $customer = new Selling();
        $customer = $customer->customer;
        $data = (object)[
            'date' => '',
            'customer' => '',
            'vehicle' => '',
            'driver' => '',
            'driver_pocket_money' => '',
            'net_profit' => '',
            'purchasing_method' => '',
            'notes' => '',
            'status' => '',
            'payment_type' => ''
        ];

        $title = 'Data Penjualan';
        $route = route('selling.store');
        $type = 'create';

        var_dump($customer); die;

        return view('pages.backoffice.selling._form', compact('data', 'title', 'route', 'type'));
    }
}
