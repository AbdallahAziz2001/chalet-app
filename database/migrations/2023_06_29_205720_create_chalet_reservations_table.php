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
        Schema::create('chalet_reservations', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('chalets_id');
            $table->foreign('chalets_id')->on('chalets')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->morphs('object');
            $table->unique(['object_type', 'object_id']);
            $table->foreignId('chalet_price_discount_codes_id')->default(null)->nullable(true);
            $table->foreign('chalet_price_discount_codes_id')->on('chalet_price_discount_codes')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('start_at')->nullable(false);
            $table->date('end_at')->nullable(false);
            $table->enum('period_start', ['Morning', 'Evening'])->nullable(false);
            $table->enum('period_end', ['Morning', 'Evening'])->nullable(false);
            $table->enum('status', ['Pending', 'Accepted', 'Canceled', 'Completed'])->default('Pending')->nullable(false);
            $table->decimal('price_after_discount', 8, 2)->unsigned()->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_reservations');
    }
};
