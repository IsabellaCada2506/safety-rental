<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Admin controller for displaying the top three most rented cars.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterCarRankingRequest;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\View\View;

class CarRankingController extends Controller
{
    public function index(FilterCarRankingRequest $request): View
    {
        $validatedData = $request->validated();
        $startDate = $validatedData['start_date'] ?? null;
        $endDate = $validatedData['end_date'] ?? null;

        $cars = Car::query()
            ->with(['category'])
            ->withCount(['reservations as rental_count' => function ($query) use ($startDate, $endDate): void {
                $query->where('state', '!=', Reservation::STATE_CANCELLED);

                if ($startDate !== null && $startDate !== '') {
                    $query->where('end_date', '>=', $startDate);
                }

                if ($endDate !== null && $endDate !== '') {
                    $query->where('start_date', '<=', $endDate);
                }
            }])
            ->orderByDesc('rental_count')
            ->orderBy('plate')
            ->orderBy('id')
            ->get();

        $rankedCars = [];
        $position = 1;

        foreach ($cars as $car) {
            $rentalCount = $car->getRentalCount();

            if ($rentalCount < 1) {
                continue;
            }

            $rankedCars[] = [
                'position' => $position,
                'car' => $car,
                'rentalCount' => $rentalCount,
            ];

            $position++;

            if ($position > 3) {
                break;
            }
        }

        $viewData = [];
        $viewData['title'] = __('ranking.admin_title');
        $viewData['rankings'] = $rankedCars;
        $viewData['startDate'] = $startDate;
        $viewData['endDate'] = $endDate;

        return view('admin.car-ranking.index')->with('viewData', $viewData);
    }
}
