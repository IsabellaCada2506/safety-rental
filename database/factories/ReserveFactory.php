<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Factory for vehicle rental reservations.
 */

namespace Database\Factories;

use App\Models\Car;
use App\Models\Location;
use App\Models\Reserve;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Reserve> */
class ReserveFactory extends Factory
{
    protected $model = Reserve::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 day', '+10 days');
        $endDate = (clone $startDate)->modify('+3 days');

        return [
            'code' => 'SR-'.fake()->unique()->numerify('########-######'),
            'user_id' => User::factory(),
            'car_id' => Car::factory(),
            'location_id' => Location::factory(),
            'state_id' => State::factory()->pending(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_amount' => 0,
        ];
    }
}
