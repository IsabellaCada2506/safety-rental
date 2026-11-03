<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Customer controller for creating simulated reservation payments.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(int $id): View
    {
        $reservation = Reservation::query()
            ->with(['user', 'car.category', 'location', 'payment'])
            ->findOrFail($id);

        $this->authorize('create', [Payment::class, $reservation]);

        $methodOptions = [];
        foreach (Payment::availableMethods() as $method) {
            $methodOptions[$method] = Payment::methodLabel($method);
        }

        $viewData = [];
        $viewData['title'] = __('payment.title_create', ['code' => $reservation->getCode()]);
        $viewData['reservation'] = $reservation;
        $viewData['methodOptions'] = $methodOptions;
        $viewData['approvedAmount'] = $reservation->getTotalPrice();

        return view('user.payment.create')->with('viewData', $viewData);
    }

    public function store(StorePaymentRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $reservation = Reservation::query()
            ->with(['user', 'car.category', 'location', 'payment'])
            ->findOrFail($id);

        $this->authorize('create', [Payment::class, $reservation]);

        if (! $reservation->isPayable()) {
            return back()
                ->withInput()
                ->withErrors(['error' => __('payment.not_payable')]);
        }

        $approvedAmount = (float) $reservation->getTotalPrice();

        if (array_key_exists('amount', $validatedData) && $validatedData['amount'] !== null) {
            $submittedAmount = (float) $validatedData['amount'];

            if (abs($submittedAmount - $approvedAmount) > 0.009) {
                return back()
                    ->withInput()
                    ->withErrors(['error' => __('payment.amount_mismatch')]);
            }
        }

        $simulatedResult = (string) $validatedData['simulated_result'];
        $isSuccessful = $simulatedResult === Payment::SIMULATED_RESULT_SUCCESS;

        do {
            $code = random_int(10000000, 99999999);
        } while (Payment::query()->where('code', $code)->exists());

        do {
            $transactionCode = random_int(10000000, 99999999);
        } while (Payment::query()->where('transaction_code', $transactionCode)->exists());

        $payment = new Payment;
        $payment->setReservationId($reservation->getId());
        $payment->setCode($code);
        $payment->setAmount($approvedAmount);
        $payment->setMethod((string) $validatedData['method']);
        $payment->setTransactionCode($transactionCode);
        $payment->setStatus($isSuccessful ? Payment::STATUS_COMPLETED : Payment::STATUS_FAILED);
        $payment->setDate(Carbon::now());
        $payment->save();

        if ($isSuccessful) {
            $reservation->setPaymentId($payment->getId());
            $reservation->save();

            return redirect()
                ->route('reservations.show', ['id' => $reservation->getId()])
                ->with('success', __('payment.completed_success'));
        }

        return redirect()
            ->route('reservations.show', ['id' => $reservation->getId()])
            ->withErrors(['error' => __('payment.failed_reported')]);
    }
}
