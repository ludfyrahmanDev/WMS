<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customer_alias', function (Blueprint $table) {
            $table->dropColumn('deleted_at'); // Atau bisa pakai $table->dropSoftDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('customer_alias', function (Blueprint $table) {
            $table->softDeletes(); // Kalau ingin restore di rollback
        });
    }
};
