<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Business logic for car inventory management.
 */

namespace App\Services;

use App\Models\Car;
use App\Services\Contracts\CarServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class CarService implements CarServiceInterface
{
    public function getAll(): Collection
    {
        return Car::all();
    }

    public function findOrFail(int $id): Car
    {
        return Car::findOrFail($id);
    }

    public function getActiveCarsWithCategory(): Collection
    {
        return Car::with('category')
            ->where('status', Car::STATUS_ACTIVE)
            ->get();
    }

    public function findActiveWithCategoryOrFail(int $id): Car
    {
        return Car::with('category')
            ->where('status', Car::STATUS_ACTIVE)
            ->findOrFail($id);
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
