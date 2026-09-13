<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-13
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
        return Car::with(['category', 'location'])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function findOrFail(int $id): Car
    {
        return Car::with(['category', 'location'])->findOrFail($id);
    }

    public function getActiveCarsWithCategory(): Collection
    {
        return Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function findActiveWithCategoryOrFail(int $id): Car
    {
        return Car::query()
            ->with(['category', 'location'])
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

        return $query->orderBy('id', 'desc')->get();
    }

    public function createFromValidated(array $validatedData): Car
    {
        $car = new Car;
        $car->setPlate((string) $validatedData['plate']);
        $car->setColor((string) $validatedData['color']);
        if (isset($validatedData['soat'])) {
            $car->setSoat((string) $validatedData['soat']);
        }
        if (isset($validatedData['transit_license'])) {
            $car->setTransitLicense((string) $validatedData['transit_license']);
        }
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
        if (isset($validatedData['soat'])) {
            $car->setSoat((string) $validatedData['soat']);
        }
        if (isset($validatedData['transit_license'])) {
            $car->setTransitLicense((string) $validatedData['transit_license']);
        }
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
            $this->isActive($car) ? Car::STATUS_DEACTIVATED : Car::STATUS_ACTIVE
        );
        $car->save();

        return $car;
    }

    public function isActive(Car $car): bool
    {
        return $car->getStatus() === Car::STATUS_ACTIVE;
    }
}
