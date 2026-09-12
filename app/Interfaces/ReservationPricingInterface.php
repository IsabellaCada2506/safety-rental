<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Interface defining the contract for calculating rental durations and totals.
 */

namespace App\Interfaces;

use App\Models\Car;
use Carbon\Carbon;

interface ReservationPricingInterface
{
    public function calculateDays(Carbon|string $startDate, Carbon|string $endDate): int;

    public function calculateTotal(Car $car, Carbon|string $startDate, Carbon|string $endDate): int;
}
