<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Contract defining the business operations available for car inventory management.
 */

namespace App\Services\Contracts;

use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

interface CarServiceInterface
{
    public function getAll(): Collection;

    public function findOrFail(int $id): Car;

    public function getActiveCarsWithCategory(): Collection;

    public function findActiveWithCategoryOrFail(int $id): Car;

    public function createFromValidated(array $validatedData): Car;

    public function updateFromValidated(Car $car, array $validatedData): Car;

    public function toggleStatus(Car $car): Car;
}
