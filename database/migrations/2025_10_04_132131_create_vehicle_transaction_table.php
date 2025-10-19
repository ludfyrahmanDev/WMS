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
        Schema::create('vehicle_transaction', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('vehicle');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('driver');
            $table->text('product')->nullable();
             $table->text('customer')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('ongkosan')->nullable();
            $table->integer('drivers_pocket_money');
            $table->integer('setoran')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_transaction');
    }
};
