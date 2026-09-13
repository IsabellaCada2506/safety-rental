<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Business logic for vehicle category management.
 */

namespace App\Services;

use App\Interfaces\CategoryServiceInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService implements CategoryServiceInterface
{
    public function getAll(): Collection
    {
        return Category::query()->orderBy('brand')->orderBy('model')->get();
    }

    public function getAllWithCarsCount(): Collection
    {
        return Category::withCount('cars')->get();
    }

    public function findOrFail(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function findWithCarsCountOrFail(int $id): Category
    {
        return Category::withCount('cars')->findOrFail($id);
    }

    public function createFromValidated(array $validatedData): Category
    {
        $category = new Category;
        $category->setModel((string) $validatedData['model']);
        $category->setBrand((string) $validatedData['brand']);
        $category->setType((string) $validatedData['type']);
        $category->setPassengerCapacity((int) $validatedData['passenger_capacity']);
        $category->setLuggageCapacity((int) $validatedData['luggage_capacity']);
        $category->save();

        return $category;
    }

    public function updateFromValidated(Category $category, array $validatedData): Category
    {
        $category->setModel((string) $validatedData['model']);
        $category->setBrand((string) $validatedData['brand']);
        $category->setType((string) $validatedData['type']);
        $category->setPassengerCapacity((int) $validatedData['passenger_capacity']);
        $category->setLuggageCapacity((int) $validatedData['luggage_capacity']);
        $category->save();

        return $category;
    }

    public function canBeDeleted(Category $category): bool
    {
        return $category->getCarsCount() === 0;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
