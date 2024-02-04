<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\Filterable;

class SpendingCategory extends Model
{
    use HasFactory, Filterable;

    protected $table = 'spending_category';

    protected $fillable = [
        'spending_category',
        // 'spending_types'
    ];

    public function getIDSaldo()
    {
        return SpendingCategory::where('spending_category', 'saldo')->value('id');
    }
}
