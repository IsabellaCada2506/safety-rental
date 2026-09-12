<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Adds reservation_id to payments so failed and refunded attempts stay linked.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table): void {
            $table->foreignId('reservation_id')
                ->nullable()
                ->after('id')
                ->constrained('reservations')
                ->nullOnDelete();
        });

        $linkedReservations = DB::table('reservations')
            ->whereNotNull('payment_id')
            ->get();

        foreach ($linkedReservations as $reservation) {
            DB::table('payments')
                ->where('id', $reservation->payment_id)
                ->update(['reservation_id' => $reservation->id]);
        }
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('reservation_id');
        });
    }
};
