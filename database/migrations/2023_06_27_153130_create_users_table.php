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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('first_name', 50)->nullable(false);
            $table->string('last_name', 50)->nullable(false);
            $table->string('username', 50)->unique()->nullable(false);
            $table->string('email', 255)->unique()->nullable(true);
            $table->timestamp('email_verified_at', 0)->nullable();
            $table->string('mobile', 25)->unique()->nullable(false);
            $table->string('password', 64)->nullable(false);
            $table->enum('gender', ['Male', 'Female'])->default('Male')->nullable(true);
            $table->date('birthday')->default(now()->format('Y-m-d'))->nullable(true);
            $table->decimal('balance', 8, 2)->unsigned()->default(0)->nullable(false);
            $table->string('account_picture', 125)->nullable(false);
            $table->string('fcm_token', 255)->unique()->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
