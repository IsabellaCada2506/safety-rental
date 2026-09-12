<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Authorization policy governing reservation views, updates, and cancellations.
 */

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->isAdmin() || $reservation->getUserId() === $user->getId();
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        $canAccess = $user->isAdmin() || $reservation->getUserId() === $user->getId();

        return $canAccess && $reservation->isCancellable();
    }

    public function confirm(User $user, Reservation $reservation): bool
    {
        return $user->isAdmin() && $reservation->isPending();
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $user->isAdmin();
    }
}
