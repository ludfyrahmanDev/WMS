<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory, Filterable;

    protected $table = 'stock';

    protected $fillable = [
        'product_id',
        'purchase_date',
        'first_stock',
        'stock_in_use',
        'last_stock'
    ];
}
