<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductMovementFactory extends Factory
{
    protected $model = ProductMovement::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'movement_type' => 'in',
            'movement_category' => 'purchase_order',
            'quantity' => fake()->numberBetween(1, 20),
            'movement_date' => now()->format('Y-m-d'),
        ];
    }

    public function in(): static
    {
        return $this->state(fn () => [
            'movement_type' => 'in',
            'movement_category' => fake()->randomElement(['purchase_order', 'initial_stock', 'return_from_customer', 'transfer_in']),
        ]);
    }

    public function out(): static
    {
        return $this->state(fn () => [
            'movement_type' => 'out',
            'movement_category' => fake()->randomElement(['sale', 'damage', 'expired', 'sample', 'transfer_out']),
        ]);
    }

    public function adjustment(): static
    {
        return $this->state(fn () => [
            'movement_type' => 'adjustment',
            'movement_category' => fake()->randomElement(['positive_adjustment', 'negative_adjustment', 'write_off']),
        ]);
    }
}
