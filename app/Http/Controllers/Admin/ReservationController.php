<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Admin controller for auditing, confirming, and managing customer reservations.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ReservationServiceInterface;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    private readonly ReservationServiceInterface $reservationService;

    public function __construct(ReservationServiceInterface $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index(Request $request): View
    {
        $stateFilter = $request->query('state');

        $viewData = [];
        $viewData['title'] = __('reservation.admin_title_index');
        $viewData['reservations'] = $this->reservationService->getFiltered($stateFilter);
        $viewData['currentState'] = $stateFilter;

        return view('admin.reservations.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $reservation = $this->reservationService->findWithRelationsOrFail($id);

        $viewData = [];
        $viewData['title'] = __('reservation.admin_title_show', ['code' => $reservation->getCode()]);
        $viewData['reservation'] = $reservation;

        return view('admin.reservations.show')->with('viewData', $viewData);
    }

    public function confirm(int $id): RedirectResponse
    {
        $reservation = $this->reservationService->findOrFail($id);

        try {
            $this->reservationService->confirmReservation($reservation);

            return redirect()
                ->route('admin.reservation.show', ['id' => $id])
                ->with('success', __('reservation.confirmed_success'));
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.reservation.show', ['id' => $id])
                ->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function cancel(int $id): RedirectResponse
    {
        $reservation = $this->reservationService->findOrFail($id);

        try {
            $this->reservationService->cancelReservation($reservation);

            return redirect()
                ->route('admin.reservation.show', ['id' => $id])
                ->with('success', __('reservation.cancelled_success'));
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.reservation.show', ['id' => $id])
                ->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
