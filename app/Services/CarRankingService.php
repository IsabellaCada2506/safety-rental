<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Calculates the top rented cars excluding cancelled reservations, with deterministic ties.
 */

namespace App\Services;

use App\Interfaces\CarRankingServiceInterface;
use App\Models\Car;
use App\Models\Reservation;

class CarRankingService implements CarRankingServiceInterface
{
    /**
     * @return list<array{position: int, car: Car, rentalCount: int}>
     */
    public function getTopCars(?string $startDate = null, ?string $endDate = null, int $limit = 3): array
    {
        $cars = Car::query()
            ->with(['category'])
            ->withCount(['reservations as rental_count' => function ($query) use ($startDate, $endDate): void {
                $query->where('state', '!=', Reservation::STATE_CANCELLED);

                if ($startDate !== null && $startDate !== '') {
                    $query->where('end_date', '>=', $startDate);
                }

                if ($endDate !== null && $endDate !== '') {
                    $query->where('start_date', '<=', $endDate);
                }
            }])
            ->orderByDesc('rental_count')
            ->orderBy('plate')
            ->orderBy('id')
            ->get();

        $rankedCars = [];
        $position = 1;

        foreach ($cars as $car) {
            $rentalCount = $car->getRentalCount();

            if ($rentalCount < 1) {
                continue;
            }

            $rankedCars[] = [
                'position' => $position,
                'car' => $car,
                'rentalCount' => $rentalCount,
            ];

            $position++;

            if ($position > $limit) {
                break;
            }
        }

        return $rankedCars;
    }
}
