<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'category' => fake()->randomElement(['men', 'women']),
            'type' => fake()->randomElement(['frame', 'lens', 'accessory']),
            'price' => fake()->numberBetween(500, 5000),
            'old_price' => null,
            'image_path' => 'images/default.jpg',
            'badge' => null,
            'badge_color' => '#1a3c2e',
            'icon' => null,
            'stocks' => fake()->numberBetween(1, 100),
            'status' => 'active',
        ];
    }

    public function bestseller(): static
    {
        return $this->state(fn (array $attributes) => [
            'badge' => 'Bestseller',
            'badge_color' => '#f4d03f',
        ]);
    }

    public function sale(): static
    {
        return $this->state(fn (array $attributes) => [
            'badge' => 'Sale',
            'old_price' => fn (array $attrs) => $attrs['price'] + fake()->numberBetween(100, 5000),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
        ]);
    }

    public function frame(): static
    {
        return $this->state(fn (array $attributes) => ['type' => 'frame']);
    }

    public function lens(): static
    {
        return $this->state(fn (array $attributes) => ['type' => 'lens']);
    }

    public function accessory(): static
    {
        return $this->state(fn (array $attributes) => ['type' => 'accessory']);
    }
}
