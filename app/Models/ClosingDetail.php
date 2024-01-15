<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClosingDetail extends Model
{
    use HasFactory, Filterable;

    protected $table = 'closing_detail';

    protected $fillable = [
        'name',
        'nominal'
    ];

    public function closing()
    {
        return $this->belongsTo(Closing::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function getClosingDetailByIDClosing($closing_id)
    {
        $result = ClosingDetail::leftJoin('customer', 'closing_detail.customer_id', '=', 'customer.id')
            ->select('name', 'nominal')
            ->where('closing_id', $closing_id)
            ->get();

        return $result;
    }
}
