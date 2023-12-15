<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleService extends Model
{
    use HasFactory, Filterable;

    protected $table = 'vehicle_service';

    protected $fillable = [
        'date',
        'driver_id',
        'vehicle_id',
        'information',
        'amount_of_expenditure',
        'mutation_category_id',
        'who_create',
        'who_update'
    ];
}
