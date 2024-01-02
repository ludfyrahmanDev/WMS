<?php

namespace App\Models;

use App\Models\SpendingCategory;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'product_category';

    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->hasMany(Product::class, 'product_category_id', 'id');
    }
}
