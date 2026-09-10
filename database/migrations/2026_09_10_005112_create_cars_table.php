<?php

/**
 * Author: Wendy
 * Date: 09/09/2026
 * Description: Migration to create the cars table with all inventory attributes.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('plate')->unique();
            $table->string('color');
            $table->string('soat');
            $table->string('transit_license');
            $table->integer('price_per_day');
            $table->integer('mileage');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};