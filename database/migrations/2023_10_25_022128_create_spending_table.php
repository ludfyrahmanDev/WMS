<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// import PaymentType
use App\Enums\PaymentType;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spending', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('spending_category_id');
            $table->foreign('spending_category_id')->references('id')->on('spending_category');
            // make createdby
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            // payment method
            $table->string('payment_method')->default(PaymentType::CASH)->nullable();
            $table->integer('nominal')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spending');
    }
};
