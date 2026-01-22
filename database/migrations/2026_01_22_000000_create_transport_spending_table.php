<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PaymentType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transport_spending', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('description')->nullable();
            
            $table->unsignedBigInteger('spending_category_id');
            $table->foreign('spending_category_id')->references('id')->on('spending_category');
            
            $table->unsignedBigInteger('cv_id')->nullable();
            $table->foreign('cv_id')->references('id')->on('cv');
            
            $table->enum('mutation', ['Uang Masuk', 'Uang Keluar']);
            $table->string('payment_method')->default(PaymentType::CASH)->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->string('who_create');
            $table->string('who_update');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_spending');
    }
};
