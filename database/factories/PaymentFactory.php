<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Factory for reservation payments.
 */

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Reserve;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Payment> */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'reserve_id' => Reserve::factory(),
            'amount' => fake()->randomFloat(2, 80, 2000),
            'status' => Payment::STATUS_PENDING,
            'reference' => strtoupper(fake()->bothify('PAY-####')),
        ];
    }
}
