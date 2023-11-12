<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory, Filterable;

    protected $table = 'supplier';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'pic'
    ];
}
