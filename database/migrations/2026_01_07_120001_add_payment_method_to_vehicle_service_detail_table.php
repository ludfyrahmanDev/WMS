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
        Schema::table('vehicle_service_detail', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('description')->comment('CASH or TRANSFER');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_service_detail', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
    }
};
