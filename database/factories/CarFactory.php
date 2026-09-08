<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Factory for cars referenced by reservations.
 */

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Car> */
class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'plate' => strtoupper(fake()->unique()->bothify('???###')),
            'brand' => fake()->randomElement(['Toyota', 'Chevrolet', 'Mazda', 'Renault']),
            'model_name' => fake()->randomElement(['Corolla', 'Onix', '3', 'Duster']),
            'daily_rate' => fake()->randomFloat(2, 80, 350),
        ];
    }
}
