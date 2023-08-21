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
        Schema::create('chalet_price_discount_codes', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('chalet_prices_id');
            $table->foreign('chalet_prices_id')->on('chalet_prices')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('code', 8)->unique()->nullable(false);
            $table->enum('percent', ['5', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60', '65', '70', '75', '80', '85', '90', '95'])->nullable(false);
            $table->timestamp('start_at')->nullable(false);
            $table->timestamp('end_at')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_price_discount_codes');
    }
};
