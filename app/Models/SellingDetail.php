<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellingDetail extends Model
{
    use HasFactory, Filterable;

    protected $table = 'selling_detail';

    public $timestamps = false;

    protected $fillable = [
        'selling_id',
        'product_id',
        'price',
        'price_sell',
        'qty',
        'subtotal'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->select('id', 'product');
    }
}
