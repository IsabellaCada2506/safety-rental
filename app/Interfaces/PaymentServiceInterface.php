<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Contract defining simulated payment processing, refunds, and payment queries.
 */

namespace App\Interfaces;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;

interface PaymentServiceInterface
{
    /**
     * @return Collection<int, Payment>
     */
    public function getAllWithReservation(): Collection;

    public function findWithReservationOrFail(int $id): Payment;

    /**
     * @param  array<string, mixed>  $data
     */
    public function processSimulatedPayment(Reservation $reservation, array $data): Payment;

    public function refundPayment(Payment $payment): Payment;
}
