<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\Driver;
use App\Models\Product;
use App\Models\Vehicle;
use App\Models\Supplier;
use App\Models\Traits\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOrder extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'delivery_order';

    protected $fillable = [
        'purchase_date',
        'pick_up_date',
        'supplier_id',
        'vehicle_id',
        'driver_id',
        'transaction_type',
        'grand_total',
        'total_payment',
        'status',
        'who_create',
        'who_update'
    ];

    protected $dates = ['deleted_at'];

    public function getSupplier()
    {
        return Supplier::select('id', 'name')->get();
    }

    public function getDriver()
    {
        return Driver::select('id', 'name')->get();
    }

    public function getVehicle()
    {
        return Vehicle::all();
    }

    public function getProduct()
    {
        return Product::select('id', 'product')->get();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function delivery_order_detail()
    {
        return $this->hasMany(DeliveryOrderDetail::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    
}
