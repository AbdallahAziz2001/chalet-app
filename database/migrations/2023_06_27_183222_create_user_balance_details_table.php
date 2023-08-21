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
        Schema::create('user_balance_details', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('users_id');
            $table->foreign('users_id')->on('users')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('balance', 10, 2)->unsigned()->nullable(false);
            $table->string('details', 255)->nullable(false);
            $table->enum('type', ['Withdraw', 'Deposit'])->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balance_details');
    }
};
