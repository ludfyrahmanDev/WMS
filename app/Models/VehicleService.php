<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleService extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'vehicle_service';

    protected $fillable = [
        'date',
        'driver_id',
        'vehicle_id',
        'who_create',
        'who_update'
    ];

    protected $dates = ['deleted_at'];

    public function getDriver()
    {
        return Driver::select('id', 'name')->get();
    }

    public function getVehicle()
    {
        return Vehicle::all();
    }

    // public function getSpendingCategory()
    // {
    //     return SpendingCategory::select('id', 'spending_category')->where('spending_types', 'Kendaraan')->get();
    // }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function vehicleServiceDetail()
    {
        return $this->hasMany(VehicleServiceDetail::class);
    }
}
