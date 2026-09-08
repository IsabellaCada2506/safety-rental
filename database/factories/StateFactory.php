<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Factory for reservation states.
 */

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<State> */
class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                State::NAME_PENDING,
                State::NAME_CONFIRMED,
                State::NAME_CANCELLED,
                State::NAME_COMPLETED,
            ]),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes): array => [
            'name' => State::NAME_PENDING,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'name' => State::NAME_CANCELLED,
        ]);
    }
}
