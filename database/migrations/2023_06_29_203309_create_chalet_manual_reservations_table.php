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
        Schema::create('chalet_manual_reservations', function (Blueprint $table) {
            $table->id('id');
            $table->string('national_identification_number', 15)->nullable(false);
            $table->string('first_name', 50)->nullable(false);
            $table->string('last_name', 50)->nullable(false);
            $table->string('mobile', 25)->nullable(false);
            $table->enum('gender', ['Male', 'Female'])->nullable(false);
            $table->date('birthday')->nullable(true);
            $table->string('description', 500)->default('Chalet Manual Reservations Description')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_manual_reservations');
    }
};
