<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Contract defining business operations for reservation lifecycle,
 *              availability verification, pricing calculation, and customer bookings.
 */

namespace App\Interfaces;

use App\Models\Car;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface ReservationServiceInterface
{
    /**
     * @return Collection<int, Reservation>
     */
    public function getAll(): Collection;

    /**
     * @return Collection<int, Reservation>
     */
    public function getFiltered(?string $state = null): Collection;

    /**
     * @return Collection<int, Reservation>
     */
    public function getByUserId(int $userId): Collection;

    public function findOrFail(int $id): Reservation;

    public function findWithRelationsOrFail(int $id): Reservation;

    public function isCarAvailable(
        int $carId,
        Carbon|string $startDate,
        Carbon|string $endDate,
        ?int $ignoreReservationId = null
    ): bool;

    public function calculateTotal(Car $car, Carbon|string $startDate, Carbon|string $endDate): int;

    public function calculateDays(Carbon|string $startDate, Carbon|string $endDate): int;

    /**
     * @param  array<string, mixed>  $data
     */
    public function createReservation(User $user, Car $car, Location $location, array $data): Reservation;

    public function confirmReservation(Reservation $reservation): Reservation;

    public function cancelReservation(Reservation $reservation): Reservation;
}
