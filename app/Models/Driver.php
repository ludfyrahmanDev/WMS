<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

// import traits
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'driver';

    protected $fillable = [
        'name',
        'address',
        'phone'
    ];

    protected $dates = ['deleted_at'];


    public function deliveryOrder()
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    public function vehicleService()
    {
        return $this->hasMany(VehicleService::class);
    }

    public function selling()
    {
        return $this->hasMany(Selling::class);
    }

}
