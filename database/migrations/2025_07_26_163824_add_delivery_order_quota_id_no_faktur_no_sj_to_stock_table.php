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
        Schema::table('stock', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_order_quota_id')->nullable()->after('id'); 
            $table->string('no_faktur')->nullable()->after('delivery_order_quota_id');
            $table->string('no_sj')->nullable()->after('no_faktur');

            // Foreign key
            $table->foreign('delivery_order_quota_id')
                ->references('id')->on('delivery_order_quota')
                ->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock', function (Blueprint $table) {
            $table->dropForeign(['delivery_order_quota_id']);
            $table->dropColumn(['delivery_order_quota_id', 'no_faktur', 'no_sj']);
        });
    }
};
