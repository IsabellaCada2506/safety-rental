<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Contract for calculating the top rented cars ranking for administrators.
 */

namespace App\Interfaces;

use App\Models\Car;

interface CarRankingServiceInterface
{
    /**
     * @return list<array{position: int, car: Car, rentalCount: int}>
     */
    public function getTopCars(?string $startDate = null, ?string $endDate = null, int $limit = 3): array;
}
