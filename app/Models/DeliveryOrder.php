<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory, Filterable;

    protected $table = 'delivery_order';

    protected $fillable = [
        'tanggal_pembelian',
        'tanggal_pengambilan',
        'supplier_id',
        'kendaraan_id',
        'driver_id',
        'metode_pembelian',
        'grand_total',
        'total_bayar',
        'tanggal_pembelian',
        'who_create',
        'who_update'
    ];

    
}
