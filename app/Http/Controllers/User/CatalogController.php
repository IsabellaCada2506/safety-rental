<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Controller for the car rental catalog, providing vehicle search, filtering, and detail views.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\FilterCarsRequest;
use App\Models\Car;
use App\Models\Category;
use App\Models\Location;
use App\Models\Reservation;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(FilterCarsRequest $request): View
    {
        $filters = $request->validated();

        $query = Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE);

        if (! empty($filters['search'])) {
            $searchTerm = '%'.strtolower((string) $filters['search']).'%';
            $query->where(function ($subQuery) use ($searchTerm): void {
                $subQuery->whereRaw('LOWER(plate) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(color) LIKE ?', [$searchTerm])
                    ->orWhereHas('category', function ($categoryQuery) use ($searchTerm): void {
                        $categoryQuery->whereRaw('LOWER(brand) LIKE ?', [$searchTerm])
                            ->orWhereRaw('LOWER(model) LIKE ?', [$searchTerm])
                            ->orWhereRaw('LOWER(type) LIKE ?', [$searchTerm]);
                    })
                    ->orWhereHas('location', function ($locationQuery) use ($searchTerm): void {
                        $locationQuery->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                            ->orWhereRaw('LOWER(city) LIKE ?', [$searchTerm]);
                    });
            });
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', (int) $filters['category_id']);
        }

        if (! empty($filters['location_id'])) {
            $query->where('location_id', (int) $filters['location_id']);
        }

        if (! empty($filters['start_date']) && ! empty($filters['end_date'])) {
            $startDate = (string) $filters['start_date'];
            $endDate = (string) $filters['end_date'];

            $query->whereDoesntHave('reservations', function ($reservationQuery) use ($startDate, $endDate): void {
                $reservationQuery
                    ->whereIn('state', [Reservation::STATE_PENDING, Reservation::STATE_CONFIRMED])
                    ->where(function ($subQuery) use ($startDate, $endDate): void {
                        $subQuery->where('start_date', '<=', $endDate)
                            ->where('end_date', '>=', $startDate);
                    });
            });
        }

        $cars = $query->orderBy('id', 'desc')->get();

        $viewData = [];
        $viewData['title'] = __('catalog.title_index');
        $viewData['cars'] = $cars;
        $viewData['categories'] = Category::query()->orderBy('brand')->orderBy('model')->get();
        $viewData['locations'] = Location::query()->orderBy('name')->get();
        $viewData['filters'] = $filters;

        return view('user.catalog.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $car = Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('catalog.title_show');
        $viewData['car'] = $car;

        return view('user.catalog.show')->with('viewData', $viewData);
    }
}
