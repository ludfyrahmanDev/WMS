<?php

namespace App\Models;

use App\Models\SpendingCategory;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleServiceDetail extends Model
{
    use HasFactory, Filterable;

    protected $table = 'vehicle_service_detail';

    protected $fillable = [
        'spending_category_id',
        'amount_of_expenditure',
        'description'
    ];

    public function spendingCategory()
    {
        return $this->belongsTo(SpendingCategory::class);
    }
}
