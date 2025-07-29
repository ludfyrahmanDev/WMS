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
        Schema::table('delivery_order', function (Blueprint $table) {
            $table->unsignedBigInteger('cv_id')->notNullable(); // atau ->notNullable() kalau wajib
            $table->foreign('cv_id')->references('id')->on('cv')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_order', function (Blueprint $table) {
            $table->dropForeign(['cv_id']);  // Hapus foreign key dulu
            $table->dropColumn('cv_id');     // Lalu hapus kolomnya
        });
    }
};
