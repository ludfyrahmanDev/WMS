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
        Schema::create('delivery_order_quota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id');
            $table->foreign('delivery_order_id')->references('id')->on('delivery_order');
            $table->integer('purchase_amount');
            $table->integer('subtotal');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product');

            $table->date('purchase_date');
            $table->integer('price_kg');
            $table->integer('first_stock');
            $table->integer('stock_in_use');
            $table->integer('last_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order_quota');
    }
};
