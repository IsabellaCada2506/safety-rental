<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Customer controller for creating simulated reservation payments.
 */

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Interfaces\PaymentServiceInterface;
use App\Interfaces\ReservationServiceInterface;
use App\Models\Payment;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    private readonly PaymentServiceInterface $paymentService;

    private readonly ReservationServiceInterface $reservationService;

    public function __construct(
        PaymentServiceInterface $paymentService,
        ReservationServiceInterface $reservationService
    ) {
        $this->paymentService = $paymentService;
        $this->reservationService = $reservationService;
    }

    public function create(int $id): View
    {
        $reservation = $this->reservationService->findWithRelationsOrFail($id);

        $this->authorize('create', [Payment::class, $reservation]);

        $viewData = [];
        $viewData['title'] = __('payment.title_create', ['code' => $reservation->getCode()]);
        $viewData['reservation'] = $reservation;
        $viewData['methodOptions'] = [];
        foreach ($this->paymentService->availableMethods() as $method) {
            $viewData['methodOptions'][$method] = $this->paymentService->methodLabel($method);
        }
        $viewData['approvedAmount'] = $this->reservationService->getTotalPrice($reservation);

        return view('payment.create')->with('viewData', $viewData);
    }

    public function store(StorePaymentRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $reservation = $this->reservationService->findWithRelationsOrFail($id);

        $this->authorize('create', [Payment::class, $reservation]);

        try {
            $payment = $this->paymentService->processSimulatedPayment($reservation, $validatedData);

            if ($this->paymentService->isFailed($payment)) {
                return redirect()
                    ->route('reservations.show', ['id' => $reservation->getId()])
                    ->withErrors(['error' => __('payment.failed_reported')]);
            }

            return redirect()
                ->route('reservations.show', ['id' => $reservation->getId()])
                ->with('success', __('payment.completed_success'));
        } catch (DomainException $exception) {
            return back()
                ->withInput()
                ->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
