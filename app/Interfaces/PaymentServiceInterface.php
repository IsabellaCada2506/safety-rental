<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
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

    public function isCompleted(Payment $payment): bool;

    public function isFailed(Payment $payment): bool;

    public function isRefunded(Payment $payment): bool;

    public function getStatusBadgeClass(Payment $payment): string;

    /**
     * @return list<string>
     */
    public function availableMethods(): array;

    public function methodLabel(string $method): string;

    public function getMethodLabel(Payment $payment): string;
}
