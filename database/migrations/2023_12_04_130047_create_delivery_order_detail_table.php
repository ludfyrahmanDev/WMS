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
        Schema::create('delivery_order_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('delivery_order_id');
            $table->foreign('delivery_order_id')->references('id')->on('delivery_order');

            $table->unsignedBigInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stock');

            $table->integer('purchase_amount');
            $table->integer('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order_detail');
    }
};
