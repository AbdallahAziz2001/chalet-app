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
        Schema::create('user_chalet_admins', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('users_id');
            $table->foreign('users_id')->on('users')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('chalets_id');
            $table->foreign('chalets_id')->on('chalets')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['users_id', 'chalets_id']);
            $table->boolean('is_owner')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chalet_admins');
    }
};
