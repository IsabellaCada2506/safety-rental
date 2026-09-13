<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Business logic for simulated reservation payments, amount integrity, and refunds.
 */

namespace App\Services;

use App\Interfaces\PaymentServiceInterface;
use App\Interfaces\ReservationServiceInterface;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;
use DomainException;
use Illuminate\Database\Eloquent\Collection;

class PaymentService implements PaymentServiceInterface
{
    public function __construct(
        private readonly ReservationServiceInterface $reservationService
    ) {}

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
        if (! $this->reservationService->isPayable($reservation)) {
            throw new DomainException(__('payment.not_payable'));
        }

        $approvedAmount = (float) $this->reservationService->getTotalPrice($reservation);

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
        if (! $this->isCompleted($payment)) {
            throw new DomainException(__('payment.refund_not_allowed'));
        }

        $payment->setStatus(Payment::STATUS_REFUNDED);
        $payment->save();

        return $payment;
    }

    public function isCompleted(Payment $payment): bool
    {
        return $payment->getStatus() === Payment::STATUS_COMPLETED;
    }

    public function isFailed(Payment $payment): bool
    {
        return $payment->getStatus() === Payment::STATUS_FAILED;
    }

    public function isRefunded(Payment $payment): bool
    {
        return $payment->getStatus() === Payment::STATUS_REFUNDED;
    }

    public function getStatusBadgeClass(Payment $payment): string
    {
        return match ($payment->getStatus()) {
            Payment::STATUS_COMPLETED => 'bg-success text-white',
            Payment::STATUS_FAILED => 'bg-danger text-white',
            Payment::STATUS_REFUNDED => 'bg-secondary text-white',
            default => 'bg-warning text-dark',
        };
    }

    /**
     * @return list<string>
     */
    public function availableMethods(): array
    {
        return [
            Payment::METHOD_CREDIT_CARD,
            Payment::METHOD_DEBIT_CARD,
            Payment::METHOD_BANK_TRANSFER,
            Payment::METHOD_PSE_DEBIT,
        ];
    }

    public function methodLabel(string $method): string
    {
        return match ($method) {
            Payment::METHOD_CREDIT_CARD => __('payment.method_credit_card'),
            Payment::METHOD_DEBIT_CARD => __('payment.method_debit_card'),
            Payment::METHOD_BANK_TRANSFER => __('payment.method_bank_transfer'),
            Payment::METHOD_PSE_DEBIT => __('payment.method_pse_debit'),
            default => $method,
        };
    }

    public function getMethodLabel(Payment $payment): string
    {
        return $this->methodLabel($payment->getMethod());
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
