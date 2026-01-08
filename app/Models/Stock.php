<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// soft delete
use App\Models\Product;
use App\Models\DeliveryOrderDetail;

class Stock extends Model
{
    use HasFactory, Filterable, SoftDeletes;
    // , SoftDeletes

    protected $table = 'stock';

    protected $fillable = [
        'delivery_order_id',
        'product_id',
        'purchase_date',
        'price_kg',
        'first_stock',
        'stock_in_use',
        'is_active',
        'last_stock'
    ];

    protected $casts = [
        'purchase_date' => 'datetime'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function dod()
    {
        return $this->hasOne(DeliveryOrderDetail::class, 'stock_id');
    }
}
