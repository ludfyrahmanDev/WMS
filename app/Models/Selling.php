<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\Driver;
use App\Models\Customer;
use App\Models\SellingDetail;
use Illuminate\Support\Facades\DB;

class Selling extends Model
{
    use HasFactory, Filterable;

    protected $table = 'selling';

    protected $fillable = [
        'date',
        'customer_id',
        'vehicle_id',
        'driver_id',
        'drivers_pocket_money',
        'net_profit',
        'grand_total',
        'purchasing_method',
        'notes',
        'status',
        'payment_type'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function getVehicle()
    {
        return Vehicle::all();
    }

    public function getProduct()
    {
        return DB::table('stock AS s')
            ->select('p.id', 'p.product', DB::raw('SUM(s.last_stock) AS last_stock'))
            ->leftJoin('product AS p', 's.product_id', '=', 'p.id')
            ->where('s.is_active', 1)
            ->groupBy('p.id', 'p.product') 
            ->get();
    }


    public function getCustomer()
    {
        return Customer::select('id', 'name')->get();
    }

    public function getDriver()
    {
        return Driver::select('id', 'name')->get();
    }

    public function selling_detail()
    {
        return $this->hasMany(SellingDetail::class);
    }

    public function getProductSummary()
    {
        return $this->selling_detail()
        ->join('stock', 'stock.id', '=', 'selling_detail.stock_id')
        ->join('product', 'product.id', '=', 'stock.product_id')
        ->select('product.id', 'product.product', 'selling_detail.price_sell', DB::raw('SUM((selling_detail.price_sell - selling_detail.price_kg) * qty) AS labaPerItem'), DB::raw('SUM(selling_detail.qty) as total_qty'), 'selling_detail.subtotal')
        ->groupBy('product.id', 'product.product', 'selling_detail.price_sell', 'selling_detail.subtotal')
        ->get();
    }
}
