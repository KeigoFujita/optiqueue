<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductMovement;
use App\Models\User;
use Tests\TestCase;

covers(App\Http\Controllers\Admin\InventoryController::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->admin = User::factory()->create();
});

describe('InventoryController', function () {

    describe('index()', function () {
        it('renders the inventory page with stock data', function () {
            Product::factory()->frame()->create(['stocks' => 50]);
            Product::factory()->lens()->create(['stocks' => 30]);
            Product::factory()->accessory()->create(['stocks' => 10]);

            $response = $this->actingAs($this->admin)->get(route('admin.inventory'));

            $response->assertOk();
            $response->assertViewIs('admin.inventory');
            $response->assertViewHasAll([
                'products', 'totalFrames', 'totalLenses', 'totalAccessories',
                'totalItems', 'lowStockProducts', 'movements',
            ]);
        });

        it('identifies low stock products', function () {
            Product::factory()->frame()->create(['stocks' => 5]);
            Product::factory()->frame()->create(['stocks' => 50]);

            $response = $this->actingAs($this->admin)->get(route('admin.inventory'));

            expect($response->viewData('lowStockProducts'))->toHaveCount(1);
            expect($response->viewData('totalItems'))->toBe(55);
        });

        it('handles no products gracefully', function () {
            $response = $this->actingAs($this->admin)->get(route('admin.inventory'));

            $response->assertOk();
            expect($response->viewData('products'))->toHaveCount(0);
            expect($response->viewData('totalItems'))->toBe(0);
            expect($response->viewData('lowStockProducts'))->toHaveCount(0);
        });

        it('shows recent movements', function () {
            $product = Product::factory()->frame()->create();
            ProductMovement::factory()->create(['product_id' => $product->id]);

            $response = $this->actingAs($this->admin)->get(route('admin.inventory'));

            expect($response->viewData('movements'))->toHaveCount(1);
        });
    });

});
