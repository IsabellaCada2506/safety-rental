<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Customer controller for downloading a paid reservation receipt as PDF.
 */

namespace App\Http\Controllers;

use App\Interfaces\ReceiptServiceInterface;
use App\Interfaces\ReservationServiceInterface;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ReceiptController extends Controller
{
    private readonly ReceiptServiceInterface $receiptService;

    private readonly ReservationServiceInterface $reservationService;

    public function __construct(
        ReceiptServiceInterface $receiptService,
        ReservationServiceInterface $reservationService
    ) {
        $this->receiptService = $receiptService;
        $this->reservationService = $reservationService;
    }

    public function download(int $id): Response|RedirectResponse
    {
        $reservation = $this->reservationService->findWithRelationsOrFail($id);

        $this->authorize('downloadReceipt', $reservation);

        try {
            return $this->receiptService->downloadPaidReceipt($reservation);
        } catch (DomainException $exception) {
            return redirect()
                ->route('reservations.show', ['id' => $reservation->getId()])
                ->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
