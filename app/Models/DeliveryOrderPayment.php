<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrderPayment extends Model
{
    use HasFactory, Filterable;

    protected $table = 'delivery_order_payment';

    public $timestamps = false;

    protected $fillable = [
        'delivery_order_id',
        'amount',
    ];

    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }
}
