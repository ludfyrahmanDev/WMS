<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $data = Stock::filterResource($request, [
            'product.product',
            'purchase_date',
            'first_stock',
            'stock_in_use',
            'last_stock'
        ], [])
            ->with('product')
            ->where('is_active', 1)
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('order', 'desc'))
            ->orderBy($request->get('sort_by', 'last_stock'), $request->get('order', 'asc'))
            ->paginate($request->get('per_page', 10));

        $title = 'Data Stok';
        $route = 'stock';

        return view('pages.backoffice.stock.index', compact('data', 'title', 'route'));
    }
}
