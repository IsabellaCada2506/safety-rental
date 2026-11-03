<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Factory for generating Payment model instances for testing and seeding.
 */

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'reservation_id' => null,
            'code' => fake()->unique()->numberBetween(10000000, 99999999),
            'amount' => fake()->randomFloat(2, 50000, 500000),
            'method' => fake()->randomElement(Payment::availableMethods()),
            'transaction_code' => fake()->numberBetween(10000000, 99999999),
            'status' => Payment::STATUS_COMPLETED,
            'date' => fake()->date(),
        ];
    }

    public function failed(): static
    {
        return $this->state(fn (): array => [
            'status' => Payment::STATUS_FAILED,
        ]);
    }

    public function refunded(): static
    {
        return $this->state(fn (): array => [
            'status' => Payment::STATUS_REFUNDED,
        ]);
    }
}
