<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_transaction', function (Blueprint $table) {
            $table->enum('type', ['cash', 'transfer'])->default('cash')->after('setoran');
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_transaction', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
