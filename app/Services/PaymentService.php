<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Business logic for simulated reservation payments, amount integrity, and refunds.
 */

namespace App\Services;

use App\Interfaces\PaymentServiceInterface;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;
use DomainException;
use Illuminate\Database\Eloquent\Collection;

class PaymentService implements PaymentServiceInterface
{
    public function getAllWithReservation(): Collection
    {
        return Payment::query()
            ->with(['reservation.user', 'reservation.car.category'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function findWithReservationOrFail(int $id): Payment
    {
        return Payment::query()
            ->with(['reservation.user', 'reservation.car.category', 'reservation.location'])
            ->findOrFail($id);
    }

    public function processSimulatedPayment(Reservation $reservation, array $data): Payment
    {
        if (! $reservation->isPayable()) {
            throw new DomainException(__('payment.not_payable'));
        }

        $approvedAmount = (float) $reservation->getTotalPrice();

        if (array_key_exists('amount', $data) && $data['amount'] !== null) {
            $submittedAmount = (float) $data['amount'];

            if (abs($submittedAmount - $approvedAmount) > 0.009) {
                throw new DomainException(__('payment.amount_mismatch'));
            }
        }

        $simulatedResult = (string) $data['simulated_result'];
        $isSuccessful = $simulatedResult === Payment::SIMULATED_RESULT_SUCCESS;

        $payment = new Payment;
        $payment->setReservationId($reservation->getId());
        $payment->setCode($this->generateUniqueCode());
        $payment->setAmount($approvedAmount);
        $payment->setMethod((string) $data['method']);
        $payment->setTransactionCode($this->generateUniqueTransactionCode());
        $payment->setStatus($isSuccessful ? Payment::STATUS_COMPLETED : Payment::STATUS_FAILED);
        $payment->setDate(Carbon::now());
        $payment->save();

        if ($isSuccessful) {
            $reservation->setPaymentId($payment->getId());
            $reservation->save();
        }

        return $payment;
    }

    public function refundPayment(Payment $payment): Payment
    {
        if (! $payment->isCompleted()) {
            throw new DomainException(__('payment.refund_not_allowed'));
        }

        $payment->setStatus(Payment::STATUS_REFUNDED);
        $payment->save();

        return $payment;
    }

    private function generateUniqueCode(): int
    {
        do {
            $code = random_int(10000000, 99999999);
        } while (Payment::query()->where('code', $code)->exists());

        return $code;
    }

    private function generateUniqueTransactionCode(): int
    {
        do {
            $transactionCode = random_int(10000000, 99999999);
        } while (Payment::query()->where('transaction_code', $transactionCode)->exists());

        return $transactionCode;
    }
}
