<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Factory for generating Location model instances for testing and seeding.
 */

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' Branch',
            'address' => fake()->streetAddress(),
            'headquarters' => fake()->city().' Main Headquarters',
            'telephone' => fake()->phoneNumber(),
            'city' => fake()->city(),
            'latitude' => fake()->latitude(6.1, 6.3),
            'longitude' => fake()->longitude(-75.7, -75.4),
        ];
    }
}
