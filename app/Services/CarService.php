<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Business logic for car inventory management and catalog search/filter.
 */

namespace App\Services;

use App\Interfaces\CarServiceInterface;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;

class CarService implements CarServiceInterface
{
    public function getAll(): Collection
    {
        return Car::query()->with(['category', 'location'])->get();
    }

    public function findOrFail(int $id): Car
    {
        return Car::findOrFail($id);
    }

    public function getActiveCarsWithCategory(): Collection
    {
        return Car::with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->get();
    }

    public function findActiveWithCategoryOrFail(int $id): Car
    {
        return Car::with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return Collection<int, Car>
     */
    public function searchAndFilter(array $filters): Collection
    {
        $query = Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE);

        if (! empty($filters['search'])) {
            $term = '%'.trim((string) $filters['search']).'%';
            $query->where(function ($q) use ($term): void {
                $q->where('plate', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('color', 'like', $term)
                    ->orWhereHas('category', function ($cq) use ($term): void {
                        $cq->where('brand', 'like', $term)
                            ->orWhere('model', 'like', $term)
                            ->orWhere('type', 'like', $term);
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

            $query->whereDoesntHave('reservations', function ($rq) use ($startDate, $endDate): void {
                $rq->whereIn('state', [Reservation::STATE_PENDING, Reservation::STATE_CONFIRMED])
                    ->where(function ($sub) use ($startDate, $endDate): void {
                        $sub->where('start_date', '<=', $endDate)
                            ->where('end_date', '>=', $startDate);
                    });
            });
        } elseif (! empty($filters['start_date'])) {
            $startDate = (string) $filters['start_date'];

            $query->whereDoesntHave('reservations', function ($rq) use ($startDate): void {
                $rq->whereIn('state', [Reservation::STATE_PENDING, Reservation::STATE_CONFIRMED])
                    ->where('start_date', '<=', $startDate)
                    ->where('end_date', '>=', $startDate);
            });
        }

        return $query->orderBy('price', 'asc')->get();
    }

    public function createFromValidated(array $validatedData): Car
    {
        $car = new Car;
        $car->setPlate((string) $validatedData['plate']);
        $car->setColor((string) $validatedData['color']);
        $car->setSoat((string) $validatedData['soat']);
        $car->setTransitLicense((string) $validatedData['transit_license']);
        $car->setPrice((int) $validatedData['price']);
        $car->setMileage((int) $validatedData['mileage']);
        $car->setImage($validatedData['image'] ?? null);
        $car->setDescription($validatedData['description'] ?? null);
        $car->setStatus(Car::STATUS_ACTIVE);
        $car->setCategoryId((int) $validatedData['category_id']);
        if (isset($validatedData['location_id'])) {
            $car->setLocationId((int) $validatedData['location_id']);
        }
        $car->save();

        return $car;
    }

    public function updateFromValidated(Car $car, array $validatedData): Car
    {
        $car->setPlate((string) $validatedData['plate']);
        $car->setColor((string) $validatedData['color']);
        $car->setSoat((string) $validatedData['soat']);
        $car->setTransitLicense((string) $validatedData['transit_license']);
        $car->setPrice((int) $validatedData['price']);
        $car->setMileage((int) $validatedData['mileage']);
        $car->setImage($validatedData['image'] ?? null);
        $car->setDescription($validatedData['description'] ?? null);
        $car->setCategoryId((int) $validatedData['category_id']);
        if (isset($validatedData['location_id'])) {
            $car->setLocationId((int) $validatedData['location_id']);
        }
        $car->save();

        return $car;
    }

    public function toggleStatus(Car $car): Car
    {
        $car->setStatus(
            $car->isActive() ? Car::STATUS_DEACTIVATED : Car::STATUS_ACTIVE
        );
        $car->save();

        return $car;
    }
}
