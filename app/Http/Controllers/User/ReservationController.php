<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Controller handling customer reservation flows including creation, ownership validation, detail viewing, and cancellation.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateReservationRequest;
use App\Http\Requests\User\StoreReservationRequest;
use App\Models\Car;
use App\Models\Location;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = Reservation::query()
            ->with(['car.category', 'location', 'payment'])
            ->where('user_id', (int) auth()->id())
            ->orderByDesc('created_at')
            ->get();

        $viewData = [];
        $viewData['title'] = __('reservation.title_my_reservations');
        $viewData['reservations'] = $reservations;

        return view('user.reservation.index')->with('viewData', $viewData);
    }

    public function create(CreateReservationRequest $request): View
    {
        $validatedData = $request->validated();
        $carId = (int) $validatedData['car_id'];

        $car = Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->findOrFail($carId);

        $locations = Location::query()->orderBy('name')->get();

        $viewData = [];
        $viewData['title'] = __('reservation.title_create');
        $viewData['car'] = $car;
        $viewData['locations'] = $locations;

        return view('user.reservation.create')->with('viewData', $viewData);
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $car = Car::query()->with(['category', 'location'])->findOrFail((int) $validatedData['car_id']);
        $location = Location::query()->findOrFail((int) $validatedData['location_id']);
        $user = $request->user();

        $startDate = (string) $validatedData['start_date'];
        $endDate = (string) $validatedData['end_date'];

        $isAvailable = ! Reservation::query()
            ->where('car_id', $car->getId())
            ->whereIn('state', [Reservation::STATE_PENDING, Reservation::STATE_CONFIRMED])
            ->where(function ($subQuery) use ($startDate, $endDate): void {
                $subQuery->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })
            ->exists();

        if (! $isAvailable) {
            return back()
                ->withInput()
                ->withErrors(['conflict' => __('reservation.car_unavailable')]);
        }

        do {
            $code = random_int(10000000, 99999999);
        } while (Reservation::query()->where('code', $code)->exists());

        $reservation = new Reservation;
        $reservation->setCode($code);
        $reservation->setState(Reservation::STATE_PENDING);
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setUserId($user->getId());
        $reservation->setCarId($car->getId());
        $reservation->setLocationId($location->getId());
        $reservation->save();

        return redirect()
            ->route('reservations.show', ['id' => $reservation->getId()])
            ->with('success', __('reservation.created_success'));
    }

    public function show(int $id): View
    {
        $reservation = Reservation::query()
            ->with(['user', 'car.category', 'location', 'payment'])
            ->findOrFail($id);

        $this->authorize('view', $reservation);

        $viewData = [];
        $viewData['title'] = __('reservation.title_show', ['code' => $reservation->getCode()]);
        $viewData['reservation'] = $reservation;

        return view('user.reservation.show')->with('viewData', $viewData);
    }

    public function cancel(int $id): RedirectResponse
    {
        $reservation = Reservation::query()->findOrFail($id);

        $this->authorize('cancel', $reservation);

        if (! $reservation->isCancellable()) {
            return redirect()
                ->route('reservations.show', ['id' => $id])
                ->withErrors(['error' => __('reservation.cancellation_not_allowed')]);
        }

        $reservation->setState(Reservation::STATE_CANCELLED);
        $reservation->save();

        return redirect()
            ->route('reservations.show', ['id' => $id])
            ->with('success', __('reservation.cancelled_success'));
    }
}
