<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Contract for checking location reference integrity against vehicles and reservations.
 */

namespace App\Interfaces;

use App\Models\Location;

interface LocationReferenceCheckerInterface
{
    /**
     * Determine if a location is referenced by any vehicles or reservations.
     */
    public function hasReferences(Location $location): bool;

    /**
     * Get the count of vehicles associated with the location.
     */
    public function getVehiclesCount(Location $location): int;

    /**
     * Get the count of reservations associated with the location.
     */
    public function getReservationsCount(Location $location): int;
}
