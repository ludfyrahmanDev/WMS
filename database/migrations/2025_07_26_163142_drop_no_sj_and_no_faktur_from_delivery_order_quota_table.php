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
        Schema::table('delivery_order_quota', function (Blueprint $table) {
            $table->dropColumn(['no_sj', 'no_faktur']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_order_quota', function (Blueprint $table) {
            $table->string('no_sj')->nullable()->after('id');
            $table->string('no_faktur')->nullable()->after('no_sj');
        });
    }
};
