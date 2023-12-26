<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Selling;
use App\Models\Product;
use App\Models\SellingDetail;
use App\Models\DeliveryOrder;
class DashboardController extends Controller
{
    //
    public function index(){
        $sellings = Selling::with('customer')->get();
        $products = Product::all();
        $item_sellings = SellingDetail::all();
        $delivery_orders = DeliveryOrder::all();
        $salesReportChart = $this->salesReportChart();
        return view('pages.backoffice.dashboard.dashboard', compact('sellings', 'item_sellings', 'products', 'delivery_orders','salesReportChart'));
    }
    
    private function salesReportChart(){
        // selling group by month created at
        $sellings = Selling::selectRaw('sum(grand_total) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->get();
        // make label for all month  name in one year
        $months = [];
        for ($i=1; $i <= 12; $i++) { 
            $months[] = date('F', mktime(0, 0, 0, $i, 1));
        }
        // set array value until 12 month
        $value = array_fill(0,11, 0);
        foreach ($sellings as $key => $v) {
            // check index in array months
            $monthValue = date('F', strtotime($v->month));
            $index = array_search($monthValue, $months);
            $value[$index] = $v->total;
        }
        
        return ['label' => $months, 'value' => $value, 'total' => $sellings->sum('total')];
    }
}
