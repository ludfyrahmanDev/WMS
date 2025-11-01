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
        Schema::table('delivery_order_detail', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('selling_id')->nullable()->after('delivery_order_id');
            $table->foreign('selling_id')->references('id')->on('selling')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_order_detail', function (Blueprint $table) {
            //
            $table->dropForeign(['selling_id']);
        });
    }
};
