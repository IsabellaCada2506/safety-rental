<?php

// Autor: Isabella Cadavid Posada

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @extends Factory<User> */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'role' => User::ROLE_CUSTOMER,
            'name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birth_date' => fake()->dateTimeBetween('-70 years', '-18 years'),
            'address' => fake()->address(),
            'license_number' => fake()->unique()->numberBetween(10000000, 99999999),
            'emergency_contact' => fake()->numberBetween(3000000000, 3999999999),
            'identification_number' => fake()->unique()->numberBetween(1000000000, 1999999999),
            'emergency_contact_name' => fake()->firstName(),
            'emergency_contact_last_name' => fake()->lastName(),
            'eps' => fake()->randomElement(['Sura', 'Sanitas', 'Nueva EPS']),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role' => User::ROLE_ADMIN,
        ]);
    }
}
