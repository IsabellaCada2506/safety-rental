<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Factory for generating Payment model instances for testing and seeding.
 */

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Payment> */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'code' => fake()->unique()->numberBetween(10000000, 99999999),
            'amount' => fake()->randomFloat(2, 50000, 500000),
            'method' => fake()->randomElement(['Credit Card', 'Debit Card', 'Bank Transfer']),
            'transaction_code' => fake()->numberBetween(10000000, 99999999),
            'status' => Payment::STATUS_COMPLETED,
            'date' => fake()->date(),
        ];
    }
}
