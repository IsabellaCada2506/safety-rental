<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Calculates reservation counts by state and payment totals for the admin metrics page.
 */

namespace App\Services;

use App\Interfaces\AdminMetricsServiceInterface;
use App\Models\Payment;
use App\Models\Reservation;

class AdminMetricsService implements AdminMetricsServiceInterface
{
    /**
     * @return array{
     *     reservationCounts: array<string, int>,
     *     completedAmount: float,
     *     failedAmount: float,
     *     refundedAmount: float,
     *     netSuccessfulAmount: float,
     *     hasActivity: bool
     * }
     */
    public function getMetrics(?string $startDate = null, ?string $endDate = null): array
    {
        $reservationQuery = Reservation::query();

        if ($startDate !== null && $startDate !== '') {
            $reservationQuery->where('end_date', '>=', $startDate);
        }

        if ($endDate !== null && $endDate !== '') {
            $reservationQuery->where('start_date', '<=', $endDate);
        }

        $reservations = $reservationQuery->get();

        $reservationCounts = [
            Reservation::STATE_PENDING => 0,
            Reservation::STATE_CONFIRMED => 0,
            Reservation::STATE_CANCELLED => 0,
            Reservation::STATE_COMPLETED => 0,
        ];

        foreach ($reservations as $reservation) {
            $state = $reservation->getState();

            if (array_key_exists($state, $reservationCounts)) {
                $reservationCounts[$state]++;
            }
        }

        $paymentQuery = Payment::query();

        if ($startDate !== null && $startDate !== '') {
            $paymentQuery->whereDate('date', '>=', $startDate);
        }

        if ($endDate !== null && $endDate !== '') {
            $paymentQuery->whereDate('date', '<=', $endDate);
        }

        $payments = $paymentQuery->get();

        $completedAmount = 0.0;
        $failedAmount = 0.0;
        $refundedAmount = 0.0;

        foreach ($payments as $payment) {
            if ($payment->isCompleted()) {
                $completedAmount += $payment->getAmount();
            }

            if ($payment->isFailed()) {
                $failedAmount += $payment->getAmount();
            }

            if ($payment->isRefunded()) {
                $refundedAmount += $payment->getAmount();
            }
        }

        return [
            'reservationCounts' => $reservationCounts,
            'completedAmount' => $completedAmount,
            'failedAmount' => $failedAmount,
            'refundedAmount' => $refundedAmount,
            'netSuccessfulAmount' => $completedAmount,
            'hasActivity' => $reservations->isNotEmpty() || $payments->isNotEmpty(),
        ];
    }
}
