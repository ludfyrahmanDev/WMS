<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\DeliveryOrderQuota;
use App\Models\DeliveryOrderDetail;
use App\Models\Traits\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOrder extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'delivery_order';

    protected $fillable = [
        'purchase_date',
        'supplier_id',
        'transaction_type',
        'grand_total',
        'total_payment',
        'status',
        'who_create',
        'who_update',
        'cv_id'
    ];

    protected $dates = ['deleted_at'];
    protected $appends = ['payment'];

    public function getSupplier()
    {
        return Supplier::select('id', 'name')->get();
    }


    public function getPaymentAttribute()
    {
        // get calculate amount from delivery_order_payment
        $payment = $this->delivery_order_payment()->sum('amount');
        return $payment;

    }

    public function delivery_order_payment()
    {
        return $this->hasMany(DeliveryOrderPayment::class);
    }

    public function delivery_order_quota()
    {
        return $this->hasMany(DeliveryOrderQuota::class);
    }
    public function delivery_order_quota_detail()
    {
        return $this->hasMany(DeliveryOrderDetail::class);
    }

    public function getProduct()
    {
        return Product::select('id', 'product')->get();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function delivery_order_detail()
    {
        return $this->hasMany(DeliveryOrderDetail::class);
    }

    public function details()
    {
        return $this->hasMany(DeliveryOrderDetail::class, 'delivery_order_id', 'id');
    }

    public function cv()
    {
        return $this->belongsTo(Cv::class, 'cv_id', 'id');
    }

    
}
