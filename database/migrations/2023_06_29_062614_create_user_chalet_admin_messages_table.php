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
        Schema::create('user_chalet_admin_messages', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('users_id');
            $table->foreign('users_id')->on('users')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_chalet_admins_id');
            $table->foreign('user_chalet_admins_id')->on('user_chalet_admins')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('message', 255)->nullable(false);
            $table->enum('message_by', ['User', 'Admin'])->nullable(false);
            $table->timestamp('deleted_at')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chalet_admin_messages');
    }
};
