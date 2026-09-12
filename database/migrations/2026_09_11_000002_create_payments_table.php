<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Migration to create the payments table.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('code')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('method');
            $table->unsignedBigInteger('transaction_code');
            $table->string('status');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
