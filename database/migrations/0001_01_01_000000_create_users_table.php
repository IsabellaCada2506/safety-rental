<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Migration to create the users table.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('role')->default('customer');
            $table->string('name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('address');
            $table->unsignedBigInteger('license_number')->unique();
            $table->unsignedBigInteger('emergency_contact');
            $table->unsignedBigInteger('identification_number')->unique();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_last_name');
            $table->string('eps');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
