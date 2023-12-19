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
        Schema::create('vehicle_service_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vehicle_service_id');
            $table->foreign('vehicle_service_id')->references('id')->on('vehicle_service');

            $table->unsignedBigInteger('spending_category_id');
            $table->foreign('spending_category_id')->references('id')->on('spending_category');

            $table->integer('amount_of_expenditure');
            $table->string('description');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_service_detail');
    }
};
