<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Closing extends Model
{
    use HasFactory, Filterable;

    protected $table = 'closing';

    protected $fillable = [
        'cust_has_not_paid',
        'main_balance',
        'receivables',
        'debt',
        'bri_balance',
        'business_balance',
        'shop_debt',
        'shop_capital',
    ];

    public function closing_detail()
    {
        return $this->hasMany(ClosingDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function cekDataDateNow()
    {
        $result = Closing::select('id')
        ->whereDate('created_at', now()->toDateString())
        ->get();

        return $result;
    }

    public static function getCustHasNotPaid()
    {
        $result = Selling::leftJoin('customer', 'selling.customer_id', '=', 'customer.id')
            ->select('customer_id', DB::raw('SUM(selling.grand_total - selling.total_payment) AS nominal'))
            ->where(DB::raw('(selling.grand_total - selling.total_payment)'), '<>', 0)
            // ->whereDate('selling.DATE', '<=', now()->toDateString()) // Menambahkan kondisi tanggal maksimal
            ->groupBy('customer_id')
            ->get();

        return $result;
    }

    public static function getTotalCustHasNotPaid()
    {
        $result = Selling::leftJoin('customer', 'selling.customer_id', '=', 'customer.id')
            ->select(DB::raw('SUM(selling.grand_total - selling.total_payment) AS nominal'))
            ->where(DB::raw('(selling.grand_total - selling.total_payment)'), '<>', 0)
            // ->whereDate('selling.DATE', '<=', now()->toDateString()) // Menambahkan kondisi tanggal maksimal
            // ->groupBy('customer.name')
            ->get()
            ->value('nominal');

        return $result;
    }

    public static function getHutang()
    {
        $result = DeliveryOrder::select(DB::raw('SUM(grand_total - total_payment) AS nominal'))
        ->where(DB::raw('(grand_total - total_payment)'), '<>', 0)
        ->where('status', '<>', 'Completed')
        ->get()
        ->value('nominal');

        return $result;
    }
}
