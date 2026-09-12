<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Contract defining business operations for physical branch locations.
 */

namespace App\Interfaces;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

interface LocationServiceInterface
{
    /**
     * @return Collection<int, Location>
     */
    public function getAll(): Collection;

    /**
     * @return Collection<int, Location>
     */
    public function getAllWithCounts(): Collection;

    public function findOrFail(int $id): Location;

    public function findWithAvailableCarsOrFail(int $id): Location;

    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function createFromValidated(array $validatedData): Location;

    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function updateFromValidated(Location $location, array $validatedData): Location;

    public function canBeDeleted(Location $location): bool;

    public function delete(Location $location): void;
}
