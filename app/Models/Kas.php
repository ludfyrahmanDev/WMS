<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kas';

    protected $fillable = [
        'transaction_type',
        'amount',
        'description',
        'delivery_order_id',
        'selling_id',
        'cv_id',
        'who_create',
        'who_update'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relationship with DeliveryOrder
     */
    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class, 'delivery_order_id');
    }

    /**
     * Relationship with Selling
     */
    public function selling()
    {
        return $this->belongsTo(Selling::class, 'selling_id');
    }

    /**
     * Relationship with CV
     */
    public function cv()
    {
        return $this->belongsTo(Cv::class, 'cv_id');
    }

    /**
     * Scope for debit transactions (money in)
     */
    public function scopeDebit($query)
    {
        return $query->where('transaction_type', 'debit');
    }

    /**
     * Scope for credit transactions (money out)
     */
    public function scopeKredit($query)
    {
        return $query->where('transaction_type', 'kredit');
    }

    /**
     * Scope for specific CV
     */
    public function scopeByCv($query, $cvId)
    {
        return $query->where('cv_id', $cvId);
    }

    /**
     * Get total debit amount
     */
    public static function getTotalDebit($cvId = null)
    {
        $query = self::debit();
        if ($cvId) {
            $query->where('cv_id', $cvId);
        }
        return $query->sum('amount');
    }

    /**
     * Get total credit amount
     */
    public static function getTotalKredit($cvId = null)
    {
        $query = self::kredit();
        if ($cvId) {
            $query->where('cv_id', $cvId);
        }
        return $query->sum('amount');
    }

    /**
     * Get kas balance (debit - credit)
     */
    public static function getBalance($cvId = null)
    {
        $debit = self::getTotalDebit($cvId);
        $kredit = self::getTotalKredit($cvId);
        return $debit - $kredit;
    }
}
