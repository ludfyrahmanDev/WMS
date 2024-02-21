<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'supplier';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'pic'
    ];

    protected $dates = ['deleted_at'];

    public function deliveryOrder()
    {
        return $this->hasMany(DeliveryOrder::class);
    }
}
