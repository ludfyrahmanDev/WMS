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
        //
        Schema::table('delivery_order', function (Blueprint $table) {
            // set driver_id nullable
            $table->unsignedBigInteger('driver_id')->nullable()->change();
            //set vehicle_id nullable
            $table->unsignedBigInteger('vehicle_id')->nullable()->change();
        });
    }

    /**`
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('delivery_order', function (Blueprint $table) {
            // set driver_id not nullable
            $table->unsignedBigInteger('driver_id')->nullable(false)->change();
            //set vehicle_id not nullable
            $table->unsignedBigInteger('vehicle_id')->nullable(false)->change();
        });
    }
};
