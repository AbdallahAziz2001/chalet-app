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
        Schema::create('chalet_main_facility_sub_facilities', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('chalet_main_facility_id');
            $table->foreign('chalet_main_facility_id', 'chalet_main_facility_sub_facilities_id_foreign')->on('chalet_main_facilities')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title', 75)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_main_facility_sub_facilities');
    }
};
