<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\Customer;
use App\Models\SellingDetail;
use App\Models\Traits\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Selling extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'selling';

    protected $fillable = [
        'invoice_no',
        'date',
        'customer_id',
        'vehicle_id',
        'driver_id',
        'drivers_pocket_money',
        'net_profit',
        'grand_total',
        'purchasing_method',
        'notes',
        'status',
        'payment_type'
    ];

    protected $dates = ['deleted_at'];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function getVehicle()
    {
        return Vehicle::all();
    }

    public function getProduct()
    {
        session(['cv_id' => 1]);

        return DB::table('stock AS s')
            ->select('p.id', 'p.product', DB::raw('SUM(s.last_stock) AS last_stock'))
            ->leftJoin('product AS p', 's.product_id', '=', 'p.id')
            ->leftJoin('delivery_order_detail AS dod', 's.id', '=', 'dod.stock_id')
            ->leftJoin('delivery_order AS do', 'do.id', '=', 'dod.delivery_order_id')
            ->where('s.is_active', 1)
            ->where('do.cv_id', session('cv_id'))
            ->groupBy('p.id', 'p.product')
            ->get();
    }


    public function getCustomer()
    {
        // return Customer::select('id', 'name')->get();

        $query = "
        SELECT CONCAT('cust-', id) AS id, name FROM customer
        UNION ALL
        SELECT CONCAT('alias-', id) AS id, name FROM customer_alias
         ";

        return DB::select($query);
    }

    public function getDriver()
    {
        return Driver::select('id', 'name')->get();
    }

    public function selling_detail()
    {
        return $this->hasMany(SellingDetail::class);
    }

    public function getProductSummary()
    {
        return $this->selling_detail()
            ->join('stock', 'stock.id', '=', 'selling_detail.stock_id')
            ->join('product', 'product.id', '=', 'stock.product_id')
            ->select('product.id', 'product.product', 'selling_detail.price_sell', DB::raw('SUM((selling_detail.price_sell - selling_detail.price_kg) * qty) AS labaPerItem'), DB::raw('SUM(selling_detail.qty) as total_qty'), 'selling_detail.subtotal')
            ->groupBy('product.id', 'product.product', 'selling_detail.price_sell', 'selling_detail.subtotal')
            ->get();
    }

    public static function getHeaderXML()
    {
        session(['cv_id' => 1]);

        return DB::table('cv')
            ->select('npwp')
            ->where('id', session('cv_id'))
            ->first();
    }

    public static function getHeaderXMLDetail()
    {
        session(['cv_id' => 1]);

        return DB::table('selling as a')
            ->join('customer as b', 'a.customer_id', '=', 'b.id')
            ->select([
                'a.id',
                'a.DATE as TaxInvoiceDate',
                'a.invoice_no as RefDesc',
                DB::raw('COALESCE(b.npwp, b.nik, "0000000000000000") as BuyerTin'),
                DB::raw("CASE 
                                WHEN b.npwp IS NOT NULL THEN 'TIN' 
                                ELSE 'National ID' 
                            END as BuyerDocument"),
                'b.name as BuyerName',
                'b.address as BuyerAdress',
                DB::raw("CASE 
                                WHEN b.npwp IS NOT NULL AND b.npwp != '' 
                                    THEN CONCAT('0', b.npwp, '000000')
                                WHEN b.nik IS NOT NULL AND b.nik != '' 
                                    THEN CONCAT(b.nik, '000000')
                            END as BuyerIDTKU")
            ])
            ->where('a.cv_id', session('cv_id'));
    }

    public static function getHeaderXMLDetail2()
    {
        session(['cv_id' => 1]);

        return DB::table('selling_detail as a')
            ->join('stock as b', 'a.stock_id', '=', 'b.id')
            ->join('product as c', 'b.product_id', '=', 'c.id')
            ->join('selling as d', 'a.selling_id', '=', 'd.id')
            ->select([
                'a.selling_id as id',
                'c.product as Name',
                'a.price_sell as Price',
                'a.qty as Qty',
                'a.subtotal as TaxBase',
                DB::raw('(a.subtotal * 11 / 12) as OtherTaxBase'),
                DB::raw('((a.subtotal * 11 / 12) / a.subtotal * 0.12) as VAT')
            ])
            ->where('d.cv_id', session('cv_id'));
    }

    public static  function maxInvoiceNo($tgl)
    {
        session(['cv_name' => 'N1PBB']);

        $prefix = session('cv_name') . $tgl; // Contoh: N1PBB01

         $query = "
        SELECT MAX(RIGHT(invoice_no, 3))  as max 
        FROM selling 
        WHERE LEFT(invoice_no, 7) = '" . $prefix . "'
    ";

        return DB::select($query);
    }
}
