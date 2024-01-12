<?php

namespace App\Models;

use App\Models\SpendingCategory;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spending extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'spending';

    protected $fillable = [
        'description',
        'created_by',
        'spending_category_id',
        'payment_method',
        'nominal'
    ];

    protected $dates = ['deleted_at'];

    public function spendingCategory()
    {
        return $this->belongsTo(SpendingCategory::class, 'spending_category_id', 'id');
    }

    public function getSpendingCategory()
    {
        return SpendingCategory::select('id', 'spending_category')->where('spending_types', '<>', 'Kendaraan')->get();
    }

    public static function whereIDSaldo()
    {
        $spendingCategory = new SpendingCategory();
        $spendingCategoryID = $spendingCategory->getIDSaldo();

        return self::where('spending_category_id', $spendingCategoryID)->first();
    }
}
