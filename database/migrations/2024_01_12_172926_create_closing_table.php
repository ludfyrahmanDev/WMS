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
        Schema::create('closing', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('cust_has_not_paid')->nullable();
            $table->integer('main_balance');
            $table->integer('receivables')->nullable();
            $table->integer('debt')->nullable();
            // $table->integer('bri_balance');
            // $table->integer('business_balance');
            $table->integer('shop_receivables');
            $table->integer('shop_capital');
            $table->string('who_create');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closing');
    }
};
