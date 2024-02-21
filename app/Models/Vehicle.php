<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// import traits
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'vehicle';

    protected $fillable = [
        'name',
        'license_plate',
        'brand'
    ];

    protected $dates = ['deleted_at'];

    public function service()
    {
        return $this->hasMany(VehicleService::class, 'vehicle_id');
    }

    public function selling()
    {
        return $this->hasMany(Selling::class, 'vehicle_id');
    }

    public function deliveryOrder()
    {
        return $this->hasMany(DeliveryOrder::class, 'vehicle_id');
    }
}
