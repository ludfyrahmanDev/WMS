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
        Schema::table('cv', function (Blueprint $table) {
            // check has npwp or not
            if (!Schema::hasColumn('cv', 'npwp')) {
                $table->string('npwp')->nullable()->after('name');
            }
            if (!Schema::hasColumn('cv', 'address')) {
                $table->text('address')->nullable()->after('npwp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cv', function (Blueprint $table) {
            $table->dropColumn(['npwp', 'address']);
        });
    }
};
