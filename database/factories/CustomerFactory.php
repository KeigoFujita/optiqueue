<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'otp' => null,
            'otp_expires_at' => null,
            'verified_at' => null,
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified_at' => now(),
        ]);
    }

    public function withOtp(string $otp = '123456'): static
    {
        return $this->state(fn (array $attributes) => [
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);
    }
}
