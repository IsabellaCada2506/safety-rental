<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Business logic implementation for rental location management and customer browsing.
 */

namespace App\Services;

use App\Interfaces\LocationReferenceCheckerInterface;
use App\Interfaces\LocationServiceInterface;
use App\Models\Car;
use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationService implements LocationServiceInterface
{
    private readonly LocationReferenceCheckerInterface $referenceChecker;

    public function __construct(LocationReferenceCheckerInterface $referenceChecker)
    {
        $this->referenceChecker = $referenceChecker;
    }

    public function getAll(): Collection
    {
        return Location::query()->orderBy('name')->get();
    }

    public function getAllWithCounts(): Collection
    {
        return Location::query()
            ->withCount(['cars', 'reservations'])
            ->orderBy('name')
            ->get();
    }

    public function findOrFail(int $id): Location
    {
        return Location::query()->findOrFail($id);
    }

    public function findWithAvailableCarsOrFail(int $id): Location
    {
        return Location::query()
            ->with([
                'cars' => function ($query): void {
                    $query->with('category')
                        ->where('status', Car::STATUS_ACTIVE);
                },
            ])
            ->findOrFail($id);
    }

    public function createFromValidated(array $validatedData): Location
    {
        $location = new Location;
        $location->setName((string) $validatedData['name']);
        $location->setAddress((string) $validatedData['address']);
        $location->setHeadquarters((string) $validatedData['headquarters']);
        $location->setTelephone((string) $validatedData['telephone']);
        $location->setCity((string) $validatedData['city']);
        $location->save();

        return $location;
    }

    public function updateFromValidated(Location $location, array $validatedData): Location
    {
        $location->setName((string) $validatedData['name']);
        $location->setAddress((string) $validatedData['address']);
        $location->setHeadquarters((string) $validatedData['headquarters']);
        $location->setTelephone((string) $validatedData['telephone']);
        $location->setCity((string) $validatedData['city']);
        $location->save();

        return $location;
    }

    public function canBeDeleted(Location $location): bool
    {
        return ! $this->referenceChecker->hasReferences($location);
    }

    public function delete(Location $location): void
    {
        $location->delete();
    }
}
