<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Business logic service orchestrating reservations, overlap verification,
 *              pricing calculation, and lifecycle state transitions.
 */

namespace App\Services;

use App\Interfaces\ReservationCodeGeneratorInterface;
use App\Interfaces\ReservationPricingInterface;
use App\Interfaces\ReservationServiceInterface;
use App\Models\Car;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use DomainException;
use Illuminate\Database\Eloquent\Collection;

class ReservationService implements ReservationServiceInterface
{
    private readonly ReservationPricingInterface $pricingUtil;

    private readonly ReservationCodeGeneratorInterface $codeGenerator;

    public function __construct(
        ReservationPricingInterface $pricingUtil,
        ReservationCodeGeneratorInterface $codeGenerator
    ) {
        $this->pricingUtil = $pricingUtil;
        $this->codeGenerator = $codeGenerator;
    }

    public function getAll(): Collection
    {
        return Reservation::with(['user', 'car.category', 'location', 'payment'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function getFiltered(?string $state = null): Collection
    {
        $query = Reservation::with(['user', 'car.category', 'location', 'payment'])
            ->orderByDesc('created_at');

        if ($state && in_array($state, [
            Reservation::STATE_PENDING,
            Reservation::STATE_CONFIRMED,
            Reservation::STATE_CANCELLED,
            Reservation::STATE_COMPLETED,
        ], true)) {
            $query->where('state', $state);
        }

        return $query->get();
    }

    public function getByUserId(int $userId): Collection
    {
        return Reservation::with(['car.category', 'location', 'payment'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function findOrFail(int $id): Reservation
    {
        return Reservation::findOrFail($id);
    }

    public function findWithRelationsOrFail(int $id): Reservation
    {
        return Reservation::with(['user', 'car.category', 'location', 'payment'])
            ->findOrFail($id);
    }

    public function isCarAvailable(
        int $carId,
        Carbon|string $startDate,
        Carbon|string $endDate,
        ?int $ignoreReservationId = null
    ): bool {
        $start = $startDate instanceof Carbon ? $startDate->toDateString() : $startDate;
        $end = $endDate instanceof Carbon ? $endDate->toDateString() : $endDate;

        $query = Reservation::query()
            ->where('car_id', $carId)
            ->whereIn('state', [Reservation::STATE_PENDING, Reservation::STATE_CONFIRMED])
            ->where(function ($subQuery) use ($start, $end): void {
                $subQuery->where('start_date', '<=', $end)
                    ->where('end_date', '>=', $start);
            });

        if ($ignoreReservationId !== null) {
            $query->where('id', '!=', $ignoreReservationId);
        }

        return ! $query->exists();
    }

    public function calculateTotal(Car $car, Carbon|string $startDate, Carbon|string $endDate): int
    {
        return $this->pricingUtil->calculateTotal($car, $startDate, $endDate);
    }

    public function calculateDays(Carbon|string $startDate, Carbon|string $endDate): int
    {
        return $this->pricingUtil->calculateDays($startDate, $endDate);
    }

    public function createReservation(User $user, Car $car, Location $location, array $data): Reservation
    {
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];

        if (! $this->isCarAvailable($car->getId(), $startDate, $endDate)) {
            throw new DomainException(__('reservation.car_unavailable'));
        }

        $reservation = new Reservation;
        $reservation->setCode($this->codeGenerator->generate());
        $reservation->setState(Reservation::STATE_PENDING);
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setUserId($user->getId());
        $reservation->setCarId($car->getId());
        $reservation->setLocationId($location->getId());
        $reservation->save();

        return $reservation;
    }

    public function confirmReservation(Reservation $reservation): Reservation
    {
        if ($reservation->getState() !== Reservation::STATE_PENDING) {
            throw new DomainException(__('reservation.transition_not_allowed'));
        }

        $reservation->setState(Reservation::STATE_CONFIRMED);
        $reservation->save();

        return $reservation;
    }

    public function cancelReservation(Reservation $reservation): Reservation
    {
        if (! $reservation->isCancellable()) {
            throw new DomainException(__('reservation.cancellation_not_allowed'));
        }

        $reservation->setState(Reservation::STATE_CANCELLED);
        $reservation->save();

        return $reservation;
    }
}
