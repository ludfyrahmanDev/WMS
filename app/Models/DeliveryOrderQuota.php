<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrderQuota extends Model
{
    use HasFactory, Filterable;

    protected $table = 'delivery_order_quota';

    public $timestamps = false;

    protected $fillable = [
        'delivery_order_id',
        'purchase_amount',
        'subtotal',
        'product_id',
        'purchase_date',
        'price_kg',
        'first_stock',
        'stock_in_use',
        'last_stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
