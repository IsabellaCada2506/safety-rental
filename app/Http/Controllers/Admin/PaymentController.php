<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Admin controller for reviewing payment records and applying refunds.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RefundPaymentRequest;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::query()
            ->with(['reservation.user', 'reservation.car.category'])
            ->orderByDesc('created_at')
            ->get();

        $viewData = [];
        $viewData['title'] = __('payment.admin_title_index');
        $viewData['payments'] = $payments;

        return view('admin.payment.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $payment = Payment::query()
            ->with(['reservation.user', 'reservation.car.category', 'reservation.location'])
            ->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('payment.admin_title_show', ['code' => $payment->getCode()]);
        $viewData['payment'] = $payment;
        $viewData['reservation'] = $payment->getReservation();

        return view('admin.payment.show')->with('viewData', $viewData);
    }

    public function refund(RefundPaymentRequest $request, int $id): RedirectResponse
    {
        $request->validated();
        $payment = Payment::query()->findOrFail($id);

        $this->authorize('refund', $payment);

        if (! $payment->isCompleted()) {
            return redirect()
                ->route('admin.payment.show', ['id' => $id])
                ->withErrors(['error' => __('payment.refund_not_allowed')]);
        }

        $payment->setStatus(Payment::STATUS_REFUNDED);
        $payment->save();

        return redirect()
            ->route('admin.payment.show', ['id' => $id])
            ->with('success', __('payment.refunded_success'));
    }
}
