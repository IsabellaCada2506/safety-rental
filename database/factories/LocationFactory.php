<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Factory for generating Location model instances for testing and seeding.
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
            'name' => fake()->company().' Branch',
            'address' => fake()->streetAddress(),
            'headquarters' => fake()->city().' Main Headquarters',
            'telephone' => fake()->phoneNumber(),
            'city' => fake()->city(),
        ];
    }
}
