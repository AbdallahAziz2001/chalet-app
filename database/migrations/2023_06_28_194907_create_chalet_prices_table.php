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
        Schema::create('chalet_prices', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('chalets_id');
            $table->foreign('chalets_id')->on('chalets')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('average_price', 8, 2)->unsigned()->nullable(true);
            $table->decimal('saturday_am', 8, 2)->unsigned()->nullable(true);
            $table->decimal('saturday_pm', 8, 2)->unsigned()->nullable(true);
            $table->decimal('sunday_am', 8, 2)->unsigned()->nullable(true);
            $table->decimal('sunday_pm', 8, 2)->unsigned()->nullable(true);
            $table->decimal('monday_am', 8, 2)->unsigned()->nullable(true);
            $table->decimal('monday_pm', 8, 2)->unsigned()->nullable(true);
            $table->decimal('tuesday_am', 8, 2)->unsigned()->nullable(true);
            $table->decimal('tuesday_pm', 8, 2)->unsigned()->nullable(true);
            $table->decimal('wednesday_am', 8, 2)->unsigned()->nullable(true);
            $table->decimal('wednesday_pm', 8, 2)->unsigned()->nullable(true);
            $table->decimal('thursday_am', 8, 2)->unsigned()->nullable(true);
            $table->decimal('thursday_pm', 8, 2)->unsigned()->nullable(true);
            $table->decimal('friday_am', 8, 2)->unsigned()->nullable(true);
            $table->decimal('friday_pm', 8, 2)->unsigned()->nullable(true);
            $table->timestamp('deleted_at')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_prices');
    }
};
