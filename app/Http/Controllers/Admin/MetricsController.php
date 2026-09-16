<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Admin controller for reservation and payment operational metrics.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterAdminMetricsRequest;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\View\View;

class MetricsController extends Controller
{
    public function index(FilterAdminMetricsRequest $request): View
    {
        $validatedData = $request->validated();
        $startDate = $validatedData['start_date'] ?? null;
        $endDate = $validatedData['end_date'] ?? null;

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

        $viewData = [];
        $viewData['title'] = __('metrics.admin_title');
        $viewData['reservationCounts'] = $reservationCounts;
        $viewData['completedAmount'] = $completedAmount;
        $viewData['failedAmount'] = $failedAmount;
        $viewData['refundedAmount'] = $refundedAmount;
        $viewData['netSuccessfulAmount'] = $completedAmount;
        $viewData['hasActivity'] = $reservations->isNotEmpty() || $payments->isNotEmpty();
        $viewData['startDate'] = $startDate;
        $viewData['endDate'] = $endDate;

        return view('admin.metrics.index')->with('viewData', $viewData);
    }
}
