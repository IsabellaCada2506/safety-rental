<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Controller handling customer reservation flows including creation,
 *              ownership validation, detail viewing, and cancellation.
 */

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Interfaces\CarServiceInterface;
use App\Interfaces\ReservationServiceInterface;
use App\Models\Location;
use App\Models\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    private readonly ReservationServiceInterface $reservationService;

    private readonly CarServiceInterface $carService;

    public function __construct(
        ReservationServiceInterface $reservationService,
        CarServiceInterface $carService
    ) {
        $this->reservationService = $reservationService;
        $this->carService = $carService;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('reservation.title_my_reservations');
        $viewData['reservations'] = $this->reservationService->getByUserId((int) auth()->id());

        return view('reservations.index')->with('viewData', $viewData);
    }

    public function create(Request $request): View
    {
        $carId = (int) $request->query('car_id');
        $car = $this->carService->findActiveWithCategoryOrFail($carId);
        $locations = Location::all();

        $viewData = [];
        $viewData['title'] = __('reservation.title_create');
        $viewData['car'] = $car;
        $viewData['locations'] = $locations;

        return view('reservations.create')->with('viewData', $viewData);
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $car = $this->carService->findOrFail((int) $validatedData['car_id']);
        $location = Location::findOrFail((int) $validatedData['location_id']);

        /** @var User $user */
        $user = $request->user();

        try {
            $reservation = $this->reservationService->createReservation(
                $user,
                $car,
                $location,
                $validatedData
            );

            return redirect()
                ->route('reservations.show', ['id' => $reservation->getId()])
                ->with('success', __('reservation.created_success'));
        } catch (DomainException $exception) {
            return back()
                ->withInput()
                ->withErrors(['conflict' => $exception->getMessage()]);
        }
    }

    public function show(int $id): View
    {
        $reservation = $this->reservationService->findWithRelationsOrFail($id);

        $this->authorize('view', $reservation);

        $viewData = [];
        $viewData['title'] = __('reservation.title_show', ['code' => $reservation->getCode()]);
        $viewData['reservation'] = $reservation;

        return view('reservations.show')->with('viewData', $viewData);
    }

    public function cancel(int $id): RedirectResponse
    {
        $reservation = $this->reservationService->findOrFail($id);

        $this->authorize('cancel', $reservation);

        try {
            $this->reservationService->cancelReservation($reservation);

            return redirect()
                ->route('reservations.show', ['id' => $id])
                ->with('success', __('reservation.cancelled_success'));
        } catch (DomainException $exception) {
            return redirect()
                ->route('reservations.show', ['id' => $id])
                ->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
