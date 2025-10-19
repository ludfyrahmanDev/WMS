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
        Schema::table('vehicle_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('cv_id')->nullable()->after('id');
            $table->foreign('cv_id')->references('id')->on('cv')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_transaction', function (Blueprint $table) {
            //
        });
    }
};
