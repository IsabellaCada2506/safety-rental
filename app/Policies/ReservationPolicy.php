<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Authorization policy governing reservation views, updates, and cancellations.
 */

namespace App\Policies;

use App\Interfaces\ReservationServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly ReservationServiceInterface $reservationService
    ) {}

    public function view(User $user, Reservation $reservation): bool
    {
        return $this->userService->isAdmin($user) || $reservation->getUserId() === $user->getId();
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        $canAccess = $this->userService->isAdmin($user) || $reservation->getUserId() === $user->getId();

        return $canAccess && $this->reservationService->isCancellable($reservation);
    }

    public function confirm(User $user, Reservation $reservation): bool
    {
        return $this->userService->isAdmin($user) && $this->reservationService->isPending($reservation);
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $this->userService->isAdmin($user);
    }

    public function downloadReceipt(User $user, Reservation $reservation): bool
    {
        return $reservation->getUserId() === $user->getId();
    }
}
