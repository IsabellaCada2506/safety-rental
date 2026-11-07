<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-11-06
 * Description: Add cancellation_reason column to reservations table.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table): void {
            $table->string('cancellation_reason')->nullable()->after('state');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table): void {
            $table->dropColumn('cancellation_reason');
        });
    }
};
