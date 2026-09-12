<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Contract defining the business operations available for vehicle category management.
 */

namespace App\Interfaces;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryServiceInterface
{
    public function getAll(): Collection;

    public function getAllWithCarsCount(): Collection;

    public function findOrFail(int $id): Category;

    public function findWithCarsCountOrFail(int $id): Category;

    public function createFromValidated(array $validatedData): Category;

    public function updateFromValidated(Category $category, array $validatedData): Category;

    public function canBeDeleted(Category $category): bool;

    public function delete(Category $category): void;
}
