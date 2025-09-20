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
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', ['debit', 'kredit'])->comment('debit = uang masuk, kredit = uang keluar');
            $table->decimal('amount', 15, 2);
            $table->text('description');
            $table->unsignedBigInteger('delivery_order_id')->nullable();
            $table->unsignedBigInteger('selling_id')->nullable();
            $table->unsignedBigInteger('cv_id')->nullable();
            $table->string('who_create')->nullable();
            $table->string('who_update')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('delivery_order_id')->references('id')->on('delivery_order')->onDelete('cascade');
            $table->foreign('selling_id')->references('id')->on('selling')->onDelete('cascade');
            $table->foreign('cv_id')->references('id')->on('cv')->onDelete('cascade');

            // Indexes
            $table->index(['transaction_type']);
            $table->index(['cv_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
