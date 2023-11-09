<?php

namespace App\Models;

use App\Models\SpendingCategory;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spending extends Model
{
    use HasFactory, Filterable;

    protected $table = 'spending';

    protected $fillable = [
        'description',
        'created_by',
        'spending_category_id',
        'payment_method',
        'nominal'
    ];

    public function spendingCategory()
    {
        return $this->belongsTo(SpendingCategory::class, 'spending_category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
