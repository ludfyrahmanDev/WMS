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
            $table->string('invoice_no')->nullable()->after('id');
            $table->unsignedBigInteger('cv_id')->nullable()->after('invoice_no'); // atau ->notNullable() kalau wajib
            $table->foreign('cv_id')->references('id')->on('cv')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selling', function (Blueprint $table) {
            $table->dropForeign(['cv_id']);  // Hapus foreign key dulu
            $table->dropColumn(['cv_id', 'invoice_no']);
        });
    }
};
