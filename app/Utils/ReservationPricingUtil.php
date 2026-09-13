<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Utility implementing rental days count and total price calculation.
 */

namespace App\Utils;

use App\Interfaces\ReservationPricingInterface;
use App\Models\Car;
use Carbon\Carbon;

class ReservationPricingUtil implements ReservationPricingInterface
{
    public function calculateDays(Carbon|string $startDate, Carbon|string $endDate): int
    {
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $end = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);

        $days = (int) $start->diffInDays($end);

        return max(1, $days);
    }

    public function calculateTotal(Car $car, Carbon|string $startDate, Carbon|string $endDate): int
    {
        $days = $this->calculateDays($startDate, $endDate);

        return $days * $car->getPrice();
    }
}
