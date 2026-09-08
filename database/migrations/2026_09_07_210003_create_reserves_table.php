<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Create reserves table with foreign keys to user, car, location and state.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserves', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('car_id')->constrained('cars')->restrictOnDelete();
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->foreignId('state_id')->constrained('states')->restrictOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_amount', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
