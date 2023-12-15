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
        Schema::create('vehicle_service', function (Blueprint $table) {
            $table->id();
            $table->date('date');

            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('driver');

            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('vehicle');

            $table->string('description');
            $table->integer('amount_of_expenditure');

            $table->unsignedBigInteger('spending_category_id');
            $table->foreign('spending_category_id')->references('id')->on('spending_category');

            $table->string('who_create');
            $table->string('who_update');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_service');
    }
};
