<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\Driver;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class Transport extends Model
{
    use HasFactory, Filterable;

    protected $table = 'selling';

    protected $fillable = [
        'date',
        'customer_id',
        'vehicle_id',
        'driver_id',
        'drivers_pocket_money'
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
}
