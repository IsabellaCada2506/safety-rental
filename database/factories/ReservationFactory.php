<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Factory for generating Reservation model instances for testing and seeding.
 */

namespace Database\Factories;

use App\Models\Car;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Reservation> */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $startDate = Carbon::now()->addDays(fake()->numberBetween(1, 10));
        $endDate = (clone $startDate)->addDays(fake()->numberBetween(1, 5));

        return [
            'code' => fake()->unique()->numberBetween(10000000, 99999999),
            'state' => Reservation::STATE_PENDING,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'user_id' => User::factory(),
            'car_id' => Car::factory(),
            'location_id' => Location::factory(),
            'payment_id' => null,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'state' => Reservation::STATE_CONFIRMED,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'state' => Reservation::STATE_CANCELLED,
        ]);
    }
}
