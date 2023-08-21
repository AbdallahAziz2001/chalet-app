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
        Schema::create('chalet_images', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('chalets_id');
            $table->foreign('chalets_id')->on('chalets')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->smallInteger('order')->unsigned()->nullable(false);
            $table->unique(['chalets_id', 'order']);
            $table->string('image', 125)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_images');
    }
};
