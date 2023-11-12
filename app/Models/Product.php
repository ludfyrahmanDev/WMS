<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\Filterable;
use App\Models\ProductCategory;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $table = 'product';

    protected $fillable = [
        'product_category_id',
        'product',
        'stock',
        'price',
        'price_sell'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }
}
