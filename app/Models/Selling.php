<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\Driver;
use App\Models\Customer;
use App\Models\SellingDetail;

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

    public function getVehicle()
    {
        return Vehicle::all();
    }

    public function getProduct()
    {
        return Product::select('id', 'product')->get();
    }

    public function selling_detail()
    {
        return $this->hasMany(SellingDetail::class);
    }
}
