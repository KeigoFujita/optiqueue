<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use App\Models\Product;

covers(ProductController::class);

describe('ProductController', function () {

    describe('about()', function () {
        it('returns the about page', function () {
            $response = $this->get(route('about'));

            $response->assertOk();
            $response->assertViewIs('about');
        });
    });

    describe('index()', function () {
        it('renders the home page with best sellers and category counts', function () {
            Product::factory(2)->frame()->create(['category' => 'men']);
            Product::factory(3)->frame()->create(['category' => 'women']);
            Product::factory()->lens()->create(['category' => 'men', 'price' => 1000]);
            Product::factory()->accessory()->create(['category' => 'women', 'price' => 500]);
            $bestseller = Product::factory()->bestseller()->create(['category' => 'men', 'type' => 'frame', 'price' => 2000]);
            Product::factory()->inactive()->create(['category' => 'men', 'type' => 'frame', 'price' => 3000]);

            $response = $this->get(route('home'));

            $response->assertOk();
            $response->assertViewIs('index');
            $response->assertViewHas('bestSellers');
            $response->assertViewHas('menCount', 3);
            $response->assertViewHas('womenCount', 3);
            $response->assertViewHas('lensCount', 1);
            $response->assertViewHas('accessoriesCount', 1);

            $bestSellers = $response->viewData('bestSellers');
            expect($bestSellers)->toHaveCount(1);
            expect($bestSellers->first()->id)->toBe($bestseller->id);
        });

        it('handles no products gracefully', function () {
            $response = $this->get(route('home'));

            $response->assertOk();
            expect($response->viewData('bestSellers'))->toHaveCount(0);
            expect($response->viewData('menCount'))->toBe(0);
        });

        it('excludes inactive products from best sellers', function () {
            Product::factory()->bestseller()->create(['category' => 'men', 'type' => 'frame']);
            Product::factory()->inactive()->bestseller()->create(['category' => 'women', 'type' => 'frame']);

            $response = $this->get(route('home'));

            expect($response->viewData('bestSellers'))->toHaveCount(1);
        });
    });

    describe('men()', function () {
        beforeEach(function () {
            Product::factory()->frame()->create([
                'category' => 'men',
                'badge' => 'Bestseller',
                'price' => 3000,
            ]);
            Product::factory()->frame()->create([
                'category' => 'men',
                'badge' => 'Sale',
                'old_price' => 5000,
                'price' => 3000,
            ]);
            Product::factory()->frame()->create([
                'category' => 'men',
                'price' => 1500,
            ]);
            Product::factory()->frame()->create([
                'category' => 'women',
                'price' => 2000,
            ]);
        });

        it('returns all men frames sorted by price asc by default', function () {
            $response = $this->get(route('frames.men'));

            $response->assertOk();
            $response->assertViewIs('frames.men');

            $products = $response->viewData('products');
            expect($products)->toHaveCount(3);
            expect($products[0]->price)->toBe(1500);
            expect($products[1]->price)->toBe(3000);
            expect($products[2]->price)->toBe(3000);
            expect($response->viewData('currentFilter'))->toBe('all');
            expect($response->viewData('currentSort'))->toBe('low');
        });

        it('filters by Sale', function () {
            $response = $this->get(route('frames.men', ['filter' => 'Sale']));

            $products = $response->viewData('products');
            expect($products)->toHaveCount(1);
            expect($products[0]->badge)->toBe('Sale');
        });

        it('filters by Bestseller', function () {
            $response = $this->get(route('frames.men', ['filter' => 'Bestseller']));

            $products = $response->viewData('products');
            expect($products)->toHaveCount(1);
            expect($products[0]->badge)->toBe('Bestseller');
        });

        it('sorts by price descending', function () {
            $response = $this->get(route('frames.men', ['sort' => 'high']));

            $products = $response->viewData('products');
            expect($products)->toHaveCount(3);
            expect($products[0]->price)->toBe(3000);
            expect($products->last()->price)->toBe(1500);
        });

        it('does not include women frames', function () {
            $response = $this->get(route('frames.men'));

            $products = $response->viewData('products');
            expect($products->pluck('category')->unique()->all())->toBe(['men']);
        });

        it('handles no men products', function () {
            Product::where('category', 'men')->delete();

            $response = $this->get(route('frames.men'));

            expect($response->viewData('products'))->toHaveCount(0);
        });
    });

    describe('women()', function () {
        beforeEach(function () {
            Product::factory()->frame()->create([
                'category' => 'women',
                'badge' => 'Bestseller',
                'price' => 3000,
            ]);
            Product::factory()->frame()->create([
                'category' => 'women',
                'badge' => 'Sale',
                'old_price' => 5000,
                'price' => 3000,
            ]);
            Product::factory()->frame()->create([
                'category' => 'women',
                'price' => 1500,
            ]);
            Product::factory()->frame()->create([
                'category' => 'men',
                'price' => 2000,
            ]);
        });

        it('returns all women frames sorted by price asc by default', function () {
            $response = $this->get(route('frames.women'));

            $response->assertOk();
            $response->assertViewIs('frames.women');

            $products = $response->viewData('products');
            expect($products)->toHaveCount(3);
            expect($products[0]->price)->toBe(1500);
            expect($response->viewData('currentFilter'))->toBe('all');
            expect($response->viewData('currentSort'))->toBe('low');
        });

        it('filters by Sale', function () {
            $response = $this->get(route('frames.women', ['filter' => 'Sale']));

            $products = $response->viewData('products');
            expect($products)->toHaveCount(1);
            expect($products[0]->badge)->toBe('Sale');
        });

        it('filters by Bestseller', function () {
            $response = $this->get(route('frames.women', ['filter' => 'Bestseller']));

            $products = $response->viewData('products');
            expect($products)->toHaveCount(1);
            expect($products[0]->badge)->toBe('Bestseller');
        });

        it('sorts by price descending', function () {
            $response = $this->get(route('frames.women', ['sort' => 'high']));

            $products = $response->viewData('products');
            expect($products)->toHaveCount(3);
            expect($products[0]->price)->toBe(3000);
            expect($products->last()->price)->toBe(1500);
        });

        it('does not include men frames', function () {
            $response = $this->get(route('frames.women'));

            $products = $response->viewData('products');
            expect($products->pluck('category')->unique()->all())->toBe(['women']);
        });

        it('handles no women products', function () {
            Product::where('category', 'women')->delete();

            $response = $this->get(route('frames.women'));

            expect($response->viewData('products'))->toHaveCount(0);
        });
    });
});
