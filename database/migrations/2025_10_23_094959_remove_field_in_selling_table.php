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
        Schema::table('selling', function (Blueprint $table) {
            // remove vehicle_id, driver_id, drivers_pocket_money
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['driver_id']);
            $table->dropColumn(['vehicle_id', 'driver_id', 'drivers_pocket_money']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selling', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('vehicle_id')->nullable()->after('customer_id');
            $table->unsignedBigInteger('driver_id')->nullable()->after('vehicle_id');
            $table->bigInteger('drivers_pocket_money')->default(0)->after('driver_id');
        });
    }
};
