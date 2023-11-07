<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// import traits
use App\Models\Traits\Filterable;

class Vehicle extends Model
{
    use HasFactory, Filterable;

    protected $table = 'vehicle';

    protected $fillable = [
        'name',
        'license_plate',
        'brand'
    ];
}
