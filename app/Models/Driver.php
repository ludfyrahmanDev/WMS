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


}
