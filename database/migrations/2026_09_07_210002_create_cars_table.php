<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Create cars table so reserves can reference a vehicle.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cars')) {
            return;
        }

        Schema::create('cars', function (Blueprint $table): void {
            $table->id();
            $table->string('plate')->unique();
            $table->string('brand')->nullable();
            $table->string('model_name')->nullable();
            $table->decimal('daily_rate', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
