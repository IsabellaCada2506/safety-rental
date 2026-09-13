<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Factory for generating Car model instances for testing and seeding.
 */

namespace Database\Factories;

use App\Models\Car;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Car> */
class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'plate' => fake()->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'color' => fake()->safeColorName(),
            'soat' => (string) fake()->unique()->numberBetween(10000000, 99999999),
            'price' => fake()->numberBetween(50000, 300000),
            'transit_license' => (string) fake()->unique()->numberBetween(10000000, 99999999),
            'description' => fake()->sentence(),
            'mileage' => fake()->numberBetween(1000, 100000),
            'image' => null,
            'status' => Car::STATUS_ACTIVE,
            'category_id' => null,
            'location_id' => Location::factory(),
        ];
    }
}
