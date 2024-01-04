<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory, Filterable;
    // , SoftDeletes

    protected $table = 'stock';

    protected $fillable = [
        'product_id',
        'purchase_date',
        'price_kg',
        'first_stock',
        'stock_in_use',
        'last_stock'
    ];

    // protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
