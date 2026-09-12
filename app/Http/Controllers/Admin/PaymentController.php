<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Admin controller for reviewing payment records and applying refunds.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RefundPaymentRequest;
use App\Interfaces\PaymentServiceInterface;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    private readonly PaymentServiceInterface $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('payment.admin_title_index');
        $viewData['payments'] = $this->paymentService->getAllWithReservation();

        return view('admin.payment.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $payment = $this->paymentService->findWithReservationOrFail($id);

        $viewData = [];
        $viewData['title'] = __('payment.admin_title_show', ['code' => $payment->getCode()]);
        $viewData['payment'] = $payment;
        $viewData['reservation'] = $payment->getReservation();

        return view('admin.payment.show')->with('viewData', $viewData);
    }

    public function refund(RefundPaymentRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $payment = $this->paymentService->findWithReservationOrFail($id);

        $this->authorize('refund', $payment);

        try {
            $this->paymentService->refundPayment($payment);

            return redirect()
                ->route('admin.payment.show', ['id' => $id])
                ->with('success', __('payment.refunded_success'));
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.payment.show', ['id' => $id])
                ->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
