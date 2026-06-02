<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_no' => 'ORD-'.mb_strtoupper(uniqid()),
            'customer_id' => Customer::factory(),
            'total_amount' => fake()->numberBetween(500, 5000),
            'status' => fake()->randomElement(['pending', 'processing', 'ready', 'picked-up']),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => ['status' => 'pending']);
    }

    public function processing(): static
    {
        return $this->state(fn () => ['status' => 'processing']);
    }

    public function ready(): static
    {
        return $this->state(fn () => ['status' => 'ready']);
    }

    public function pickedUp(): static
    {
        return $this->state(fn () => ['status' => 'picked-up']);
    }

    public function cancelled(): static
    {
        return $this->state(fn () => ['status' => 'cancelled']);
    }
}
