<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Seeder for populating the database with initial category data.
 */

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            ['model' => 'Corolla',   'brand' => 'Toyota',   'type' => 'Sedan',   'passenger_capacity' => 5, 'luggage_capacity' => 2],
            ['model' => 'CX-5',      'brand' => 'Mazda',    'type' => 'SUV',     'passenger_capacity' => 5, 'luggage_capacity' => 3],
            ['model' => '3 Series',  'brand' => 'BMW',      'type' => 'Sports',  'passenger_capacity' => 4, 'luggage_capacity' => 2],
            ['model' => 'Hilux',     'brand' => 'Toyota',   'type' => 'Truck',   'passenger_capacity' => 5, 'luggage_capacity' => 6],
            ['model' => 'Spark GT',  'brand' => 'Chevrolet', 'type' => 'Compact', 'passenger_capacity' => 4, 'luggage_capacity' => 1],
            ['model' => 'X5',        'brand' => 'BMW',      'type' => 'Luxury',  'passenger_capacity' => 5, 'luggage_capacity' => 4],
        ];

        foreach ($categoriesData as $categoryData) {
            $category = new Category;
            $category->setModel($categoryData['model']);
            $category->setBrand($categoryData['brand']);
            $category->setType($categoryData['type']);
            $category->setPassengerCapacity($categoryData['passenger_capacity']);
            $category->setLuggageCapacity($categoryData['luggage_capacity']);
            $category->save();
        }
    }
}
