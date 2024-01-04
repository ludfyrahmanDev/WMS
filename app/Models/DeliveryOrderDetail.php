<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrderDetail extends Model
{
    use HasFactory, Filterable;

    protected $table = 'delivery_order_detail';

    public $timestamps = false;

    protected $fillable = [
        'delivery_order_id',
        'stock_id',
        'purchase_amount',
        'subtotal'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
