<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Migration to create the categories table for vehicle classification.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('model', 100);
            $table->string('brand', 100);
            $table->string('type', 100);
            $table->integer('passenger_capacity');
            $table->integer('luggage_capacity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
