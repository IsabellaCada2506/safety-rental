<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Utility implementing location reference checking against cars and reservations.
 */

namespace App\Utils;

use App\Interfaces\LocationReferenceCheckerInterface;
use App\Models\Location;

class LocationReferenceChecker implements LocationReferenceCheckerInterface
{
    public function hasReferences(Location $location): bool
    {
        return $this->getVehiclesCount($location) > 0 || $this->getReservationsCount($location) > 0;
    }

    public function getVehiclesCount(Location $location): int
    {
        return $location->cars()->count();
    }

    public function getReservationsCount(Location $location): int
    {
        return $location->reservations()->count();
    }
}
