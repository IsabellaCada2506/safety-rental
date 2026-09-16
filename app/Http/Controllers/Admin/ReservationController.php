<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Admin controller for auditing, confirming, and managing customer reservations.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(FilterReservationRequest $request): View
    {
        $validatedData = $request->validated();
        $stateFilter = $validatedData['state'] ?? null;

        $query = Reservation::query()
            ->with(['user', 'car.category', 'location', 'payment'])
            ->orderByDesc('created_at');

        if ($stateFilter && in_array($stateFilter, [
            Reservation::STATE_PENDING,
            Reservation::STATE_CONFIRMED,
            Reservation::STATE_CANCELLED,
            Reservation::STATE_COMPLETED,
        ], true)) {
            $query->where('state', $stateFilter);
        }

        $reservations = $query->get();

        $viewData = [];
        $viewData['title'] = __('reservation.admin_title_index');
        $viewData['reservations'] = $reservations;
        $viewData['currentState'] = $stateFilter;

        return view('admin.reservation.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $reservation = Reservation::query()
            ->with(['user', 'car.category', 'location', 'payment'])
            ->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('reservation.admin_title_show', ['code' => $reservation->getCode()]);
        $viewData['reservation'] = $reservation;

        return view('admin.reservation.show')->with('viewData', $viewData);
    }

    public function confirm(int $id): RedirectResponse
    {
        $reservation = Reservation::query()->findOrFail($id);

        if ($reservation->getState() !== Reservation::STATE_PENDING) {
            return redirect()
                ->route('admin.reservation.show', ['id' => $id])
                ->withErrors(['error' => __('reservation.transition_not_allowed')]);
        }

        $reservation->setState(Reservation::STATE_CONFIRMED);
        $reservation->save();

        return redirect()
            ->route('admin.reservation.show', ['id' => $id])
            ->with('success', __('reservation.confirmed_success'));
    }

    public function cancel(int $id): RedirectResponse
    {
        $reservation = Reservation::query()->findOrFail($id);

        if (! $reservation->isCancellable()) {
            return redirect()
                ->route('admin.reservation.show', ['id' => $id])
                ->withErrors(['error' => __('reservation.cancellation_not_allowed')]);
        }

        $reservation->setState(Reservation::STATE_CANCELLED);
        $reservation->save();

        return redirect()
            ->route('admin.reservation.show', ['id' => $id])
            ->with('success', __('reservation.cancelled_success'));
    }
}
