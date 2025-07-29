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
            // Hapus foreign key dulu
            $table->dropForeign(['delivery_order_quota_id']);
            // Lalu hapus kolomnya
            $table->dropColumn(['delivery_order_quota_id', 'no_faktur', 'no_sj']);
        });

        // Tambah kolom ke tabel delivery_order_detail
        Schema::table('delivery_order_detail', function (Blueprint $table) {
            $table->string('no_sj')->nullable()->after('id');       // atau sesuaikan posisi
            $table->string('no_faktur')->nullable()->after('no_sj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom ke tabel stock
        Schema::table('stock', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_order_quota_id')->nullable()->after('id');
            $table->string('no_faktur')->nullable()->after('delivery_order_quota_id');
            $table->string('no_sj')->nullable()->after('no_faktur');

            $table->foreign('delivery_order_quota_id')
                ->references('id')->on('delivery_order_quota')
                ->onDelete('set null');
        });

        // Hapus kolom dari delivery_order_detail
        Schema::table('delivery_order_detail', function (Blueprint $table) {
            $table->dropColumn(['no_sj', 'no_faktur']);
        });
    }
};
