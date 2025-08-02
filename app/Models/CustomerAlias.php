<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAlias extends Model
{
    use HasFactory;

    protected $table = 'customer_alias';

    protected $fillable = [
        'customer_id',
        'name',
        'npwp',
        'phone',
        'ongkosan',
        'borongan',
        'address'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

