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
        Schema::create('chalets', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 75)->nullable(false);
            $table->string('logo', 125)->nullable(false);
            $table->string('location', 255)->nullable(false);
            $table->decimal('latitude', 10, 8)->nullable(false);
            $table->decimal('longitude', 11, 8)->nullable(false);
            $table->unique(['latitude', 'longitude']);
            $table->string('country', 100)->nullable(false);
            $table->string('city', 50)->nullable(false);
            $table->string('description', 500)->nullable(false);
            $table->decimal('space', 6, 2)->unsigned()->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalets');
    }
};
