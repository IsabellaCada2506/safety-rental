<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Authorization policy for simulated payments and administrator refunds.
 */

namespace App\Policies;

use App\Interfaces\PaymentServiceInterface;
use App\Interfaces\ReservationServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;

class PaymentPolicy
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly ReservationServiceInterface $reservationService,
        private readonly PaymentServiceInterface $paymentService
    ) {}

    public function create(User $user, Reservation $reservation): bool
    {
        return ! $this->userService->isAdmin($user)
            && $reservation->getUserId() === $user->getId()
            && $this->reservationService->isPayable($reservation);
    }

    public function view(User $user, Payment $payment): bool
    {
        if ($this->userService->isAdmin($user)) {
            return true;
        }

        $reservation = $payment->getReservation();

        return $reservation !== null && $reservation->getUserId() === $user->getId();
    }

    public function refund(User $user, Payment $payment): bool
    {
        return $this->userService->isAdmin($user) && $this->paymentService->isCompleted($payment);
    }
}
