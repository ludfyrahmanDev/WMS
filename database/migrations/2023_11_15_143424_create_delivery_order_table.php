<?php

use App\Enums\PaymentType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_order', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->date('pick_up_date');

            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('supplier');

            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('vehicle');

            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('driver');

            $table->enum('transaction_type', ['Tempo Panjang', 'Kontan']);
            $table->integer('grand_total');
            $table->integer('total_payment');
            $table->string('status');
            $table->string('notes')->nullable();
            $table->string('who_create');
            $table->string('who_update');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order');
    }
};
