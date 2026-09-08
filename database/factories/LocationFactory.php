<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Factory for rental locations.
 */

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Location> */
class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company().' Branch',
            'city' => fake()->city(),
            'address' => fake()->address(),
        ];
    }
}
