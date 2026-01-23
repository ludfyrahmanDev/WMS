<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('delivery_order_quota', function (Blueprint $table) {
            //
            $table->float('purchase_amount')->change();
            $table->float('first_stock')->change();
            $table->float('stock_in_use')->change();
            $table->float('last_stock')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_order_quota', function (Blueprint $table) {
            //
            $table->integer('purchase_amount')->change();
            $table->integer('first_stock')->change();
            $table->integer('stock_in_use')->change();
            $table->integer('last_stock')->change();
        });
    }
};
