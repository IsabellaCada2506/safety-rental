<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Authorization policy for simulated payments and administrator refunds.
 */

namespace App\Policies;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;

class PaymentPolicy
{
    public function create(User $user, Reservation $reservation): bool
    {
        return ! $user->isAdmin()
            && $reservation->getUserId() === $user->getId()
            && $reservation->isPayable();
    }

    public function view(User $user, Payment $payment): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        $reservation = $payment->getReservation();

        return $reservation !== null && $reservation->getUserId() === $user->getId();
    }

    public function refund(User $user, Payment $payment): bool
    {
        return $user->isAdmin() && $payment->isCompleted();
    }
}
