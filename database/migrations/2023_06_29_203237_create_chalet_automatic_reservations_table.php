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
        Schema::create('chalet_automatic_reservations', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('users_id');
            $table->foreign('users_id')->on('users')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('chalet_rating_user', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'])->nullable(false);
            $table->string('description', 500)->default('Chalet Automatic Reservations Description')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_automatic_reservations');
    }
};
