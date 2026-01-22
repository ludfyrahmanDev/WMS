<?php

namespace App\Models;

use App\Models\SpendingCategory;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportSpending extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'transport_spending';

    protected $fillable = [
        'description',
        'created_by',
        'spending_category_id',
        'cv_id',
        'payment_method',
        'nominal',
        'date',
        'mutation',
        'who_create',
        'who_update'
    ];

    protected $dates = ['deleted_at'];

    public function spendingCategory()
    {
        return $this->belongsTo(SpendingCategory::class, 'spending_category_id', 'id');
    }

    public function cv()
    {
        return $this->belongsTo(CV::class, 'cv_id', 'id');
    }

    public function getSpendingCategory()
    {
        return SpendingCategory::select('id', 'spending_category')->get();
    }

    public static function whereIDSaldo()
    {
        $spendingCategory = new SpendingCategory();
        $spendingCategoryID = $spendingCategory->getIDSaldo();

        return self::where('spending_category_id', $spendingCategoryID)->first();
    }
}
