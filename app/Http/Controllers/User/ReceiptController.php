<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Customer controller for downloading a paid reservation receipt as PDF.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ReceiptController extends Controller
{
    private readonly PDF $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function download(int $id): Response|RedirectResponse
    {
        $reservation = Reservation::query()
            ->with(['user', 'car.category', 'location', 'payment'])
            ->findOrFail($id);

        $this->authorize('downloadReceipt', $reservation);

        if (! $reservation->hasSuccessfulPayment()) {
            return redirect()
                ->route('reservations.show', ['id' => $reservation->getId()])
                ->withErrors(['error' => __('payment.receipt_not_paid')]);
        }

        $payment = $reservation->getPayment();
        $car = $reservation->getCar();
        $category = $car?->getCategory();

        $viewData = [];
        $viewData['title'] = __('payment.receipt_label');
        $viewData['documentName'] = __('payment.receipt_label');
        $viewData['disclaimer'] = __('payment.not_an_invoice');
        $viewData['reservationCode'] = $reservation->getCode();
        $viewData['vehicleName'] = trim(($category?->getBrand() ?? '').' '.($category?->getModel() ?? ''));
        $viewData['vehiclePlate'] = $car?->getPlate() ?? '';
        $viewData['startDate'] = $reservation->getStartDate()?->format('d/m/Y') ?? '';
        $viewData['endDate'] = $reservation->getEndDate()?->format('d/m/Y') ?? '';
        $viewData['amount'] = $payment?->getAmount() ?? 0.0;
        $viewData['currency'] = __('payment.currency');
        $viewData['transactionCode'] = $payment?->getTransactionCode();
        $viewData['paymentStatus'] = $payment ? __('payment.status_'.$payment->getStatus()) : __('payment.unpaid');
        $viewData['paymentMethod'] = $payment ? $payment->getMethodLabel() : '';
        $viewData['paymentDate'] = $payment?->getDate()?->format('d/m/Y') ?? '';
        $viewData['isPrintableDocument'] = true;

        $fileName = 'rental-receipt-'.$reservation->getCode().'.pdf';

        return $this->pdf->loadView('user.receipt.download', ['viewData' => $viewData])
            ->download($fileName);
    }
}
