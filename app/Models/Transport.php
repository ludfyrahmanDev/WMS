<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\Driver;
use App\Models\Selling;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class Transport extends Model
{
    use HasFactory, Filterable;

    protected $table = 'vehicle_transaction';

    protected $fillable = [
        'date',
        'vehicle_id',
        'driver_id',
        'product',
        'costumer',
        'weight',
        'ongkosan',
        'drivers_pocket_money',
        'setoran',
        'type'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function getVehicle()
    {
        return Vehicle::all('id', 'name', 'license_plate');
    }

    public function getDriver()
    {
        return Driver::all('id', 'name');
    }

    public function invoices()
    {
        return Selling::all('id', 'no_invoice');
    }

    public function getDataSellingByInvoice($id)
    {
        return DB::table('selling')
        ->join('selling_detail', 'selling.id', '=', 'selling_detail.selling_id')
        ->join('stock', 'stock.id', '=', 'selling_detail.stock_id')
        ->join('product', 'product.id', '=', 'stock.product_id')
        ->join('customer', 'customer.id', '=', 'selling.customer_id')
        ->select('selling.date', 'product.product', 'customer.name', 'selling_detail.qty')
        ->where('selling.id', $id)
        ->first();
    }
}
