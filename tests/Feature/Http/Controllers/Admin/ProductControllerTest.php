<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductMovement;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

beforeEach(function () {
    /** @var TestCase $this */
    $this->admin = User::factory()->create();
});

describe('ProductController', function () {

    describe('index()', function () {
        it('renders the products page with active products', function () {
            Product::factory(3)->create(['status' => 'active']);
            Product::factory()->inactive()->create();

            $response = $this->actingAs($this->admin)->get(route('admin.products'));

            $response->assertOk();
            $response->assertViewIs('admin.products');
            expect($response->viewData('products'))->toHaveCount(3);
            expect($response->viewData('currentFilter'))->toBe('all');
        });

        it('filters products by type', function () {
            Product::factory()->frame()->create();
            Product::factory()->lens()->create();
            Product::factory()->accessory()->create();

            $response = $this->actingAs($this->admin)->get(route('admin.products', ['filter' => 'frame']));

            expect($response->viewData('products'))->toHaveCount(1);
            expect($response->viewData('currentFilter'))->toBe('frame');
        });

        it('shows archived products', function () {
            Product::factory(2)->create(['status' => 'active']);
            Product::factory(3)->create(['status' => 'archived']);

            $response = $this->actingAs($this->admin)->get(route('admin.products', ['filter' => 'archived']));

            expect($response->viewData('products'))->toHaveCount(3);
            expect($response->viewData('currentFilter'))->toBe('archived');
        });

        it('searches products by name', function () {
            Product::factory()->create(['name' => 'Aurel Gold', 'status' => 'active']);
            Product::factory()->create(['name' => 'Ruby Red', 'status' => 'active']);

            $response = $this->actingAs($this->admin)->get(route('admin.products', ['search' => 'Aurel']));

            expect($response->viewData('products'))->toHaveCount(1);
            expect($response->viewData('currentSearch'))->toBe('Aurel');
        });

        it('orders products by latest first', function () {
            $old = Product::factory()->create(['status' => 'active']);
            $new = Product::factory()->create(['status' => 'active']);

            $response = $this->actingAs($this->admin)->get(route('admin.products'));

            $ids = $response->viewData('products')->pluck('id')->toArray();
            expect($ids)->toBe([$new->id, $old->id]);
        });

        it('handles no products', function () {
            $response = $this->actingAs($this->admin)->get(route('admin.products'));

            expect($response->viewData('products'))->toHaveCount(0);
        });
    });

    describe('store()', function () {
        it('creates a new frame product', function () {
            $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
                'name' => 'Aurel Burgundy Gold',
                'description' => 'A stylish frame',
                'category' => 'men',
                'type' => 'frame',
                'price' => 2500,
                'status' => 'active',
                'stocks' => 10,
            ]);

            $response->assertOk();
            $response->assertJson([
                'success' => true,
            ]);

            $this->assertDatabaseHas('products', [
                'name' => 'Aurel Burgundy Gold',
                'price' => 2500,
                'type' => 'frame',
                'category' => 'men',
                'stocks' => 10,
            ]);
        });

        it('creates a product with an image', function () {
            Storage::fake('public');
            $file = UploadedFile::fake()->image('frame.jpg');

            $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
                'name' => 'Ruby Frame',
                'description' => 'A red frame',
                'category' => 'women',
                'type' => 'frame',
                'price' => 3000,
                'status' => 'active',
                'image' => $file,
            ]);

            $response->assertOk();
            $product = Product::where('name', 'Ruby Frame')->first();
            expect($product)->not->toBeNull();
            expect($product->image_path)->toContain('frames/women/');
            expect(Storage::disk('public')->exists($product->image_path))->toBeTrue();
        });

        it('creates a lens product', function () {
            $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
                'name' => 'Blue Light Lens',
                'description' => 'Protective lens',
                'category' => 'lenses',
                'type' => 'lens',
                'price' => 800,
                'status' => 'active',
                'icon' => '🔵',
            ]);

            $response->assertOk();
            $this->assertDatabaseHas('products', [
                'name' => 'Blue Light Lens',
                'type' => 'lens',
            ]);
        });

        it('creates an accessory product', function () {
            $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
                'name' => 'Sunglass Case',
                'description' => 'A hard case',
                'category' => 'accessories',
                'type' => 'accessory',
                'price' => 350,
                'status' => 'active',
            ]);

            $response->assertOk();
            $this->assertDatabaseHas('products', [
                'name' => 'Sunglass Case',
                'type' => 'accessory',
            ]);
        });

        it('validates required fields', function () {
            $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
                'name' => '',
                'description' => '',
                'category' => '',
                'type' => '',
                'price' => '',
                'status' => '',
            ]);

            $response->assertSessionHasErrors(['name', 'description', 'category', 'type', 'price', 'status']);
        });

        it('validates price must be non-negative', function () {
            $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
                'name' => 'Test',
                'description' => 'Desc',
                'category' => 'men',
                'type' => 'frame',
                'price' => -10,
                'status' => 'active',
            ]);

            $response->assertSessionHasErrors(['price']);
        });
    });

    describe('edit()', function () {
        it('returns the edit page for a product', function () {
            $product = Product::factory()->frame()->create();

            $response = $this->actingAs($this->admin)->get(route('admin.products.edit', $product->id));

            $response->assertOk();
            $response->assertViewIs('admin.productmanagement');
            expect($response->viewData('product')->id)->toBe($product->id);
        });

        it('returns 404 for non-existent product', function () {
            $response = $this->actingAs($this->admin)->get(route('admin.products.edit', 99999));

            $response->assertNotFound();
        });
    });

    describe('update()', function () {
        it('updates a product', function () {
            $product = Product::factory()->frame()->create(['name' => 'Old Name']);

            $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
                'name' => 'New Name',
                'description' => 'Updated description',
                'category' => 'women',
                'type' => 'frame',
                'price' => 3500,
                'status' => 'active',
            ]);

            $response->assertOk();
            $response->assertJson([
                'success' => true,
            ]);

            $product->refresh();
            expect($product->name)->toBe('New Name');
            expect($product->price)->toBe(3500);
        });

        it('updates product image', function () {
            Storage::fake('public');
            $product = Product::factory()->frame()->create(['image_path' => 'old/image.jpg']);

            $file = UploadedFile::fake()->image('new-frame.jpg');

            $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
                'name' => $product->name,
                'description' => $product->description,
                'category' => 'men',
                'type' => 'frame',
                'price' => $product->price,
                'status' => 'active',
                'image' => $file,
            ]);

            $response->assertOk();
            $product->refresh();
            expect($product->image_path)->toContain('frames/men/');
            expect(Storage::disk('public')->exists('old/image.jpg'))->toBeFalse();
            expect(Storage::disk('public')->exists($product->image_path))->toBeTrue();
        });

        it('archives a product', function () {
            $product = Product::factory()->create(['status' => 'active']);

            $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
                'name' => $product->name,
                'description' => $product->description,
                'category' => 'men',
                'type' => 'frame',
                'price' => $product->price,
                'status' => 'archived',
            ]);

            $response->assertOk();
            expect($product->fresh()->status)->toBe('archived');
        });

        it('validates required fields on update', function () {
            $product = Product::factory()->create();

            $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
                'name' => '',
                'description' => '',
                'category' => '',
                'type' => '',
                'price' => '',
                'status' => '',
            ]);

            $response->assertSessionHasErrors(['name', 'description', 'category', 'type', 'price', 'status']);
        });
    });

    describe('movements()', function () {
        it('renders the product movements page', function () {
            $product = Product::factory()->frame()->create();

            $response = $this->actingAs($this->admin)->get(route('admin.products.movements', $product->id));

            $response->assertOk();
            $response->assertViewIs('admin.productmovements');
            expect($response->viewData('product')->id)->toBe($product->id);
        });

        it('shows movement totals', function () {
            $product = Product::factory()->frame()->create(['stocks' => 15]);
            ProductMovement::factory()->create([
                'product_id' => $product->id,
                'movement_type' => 'in',
                'quantity' => 10,
            ]);
            ProductMovement::factory()->create([
                'product_id' => $product->id,
                'movement_type' => 'out',
                'quantity' => 5,
            ]);

            $response = $this->actingAs($this->admin)->get(route('admin.products.movements', $product->id));

            expect($response->viewData('movements'))->toHaveCount(2);
            expect($response->viewData('totalIn'))->toBe(10);
            expect($response->viewData('totalOut'))->toBe(5);
        });

        it('handles product with no movements', function () {
            $product = Product::factory()->frame()->create();

            $response = $this->actingAs($this->admin)->get(route('admin.products.movements', $product->id));

            expect($response->viewData('movements'))->toHaveCount(0);
            expect($response->viewData('totalIn'))->toBe(0);
            expect($response->viewData('totalOut'))->toBe(0);
        });
    });

    describe('storeMovement()', function () {
        it('records a stock in movement', function () {
            $product = Product::factory()->frame()->create(['stocks' => 10]);

            $response = $this->actingAs($this->admin)->post(route('admin.products.movements.store', $product->id), [
                'movement_type' => 'in',
                'movement_category' => 'purchase_order',
                'quantity' => 5,
                'movement_date' => now()->format('Y-m-d'),
            ]);

            $response->assertOk();
            $response->assertJsonStructure([
                'success', 'message', 'movement', 'stock',
            ]);

            expect($product->fresh()->stocks)->toBe(15);
            $this->assertDatabaseHas('product_movements', [
                'product_id' => $product->id,
                'movement_type' => 'in',
                'quantity' => 5,
            ]);
        });

        it('records a stock out movement', function () {
            $product = Product::factory()->frame()->create(['stocks' => 10]);

            $response = $this->actingAs($this->admin)->post(route('admin.products.movements.store', $product->id), [
                'movement_type' => 'out',
                'movement_category' => 'sale',
                'quantity' => 3,
                'movement_date' => now()->format('Y-m-d'),
            ]);

            $response->assertOk();
            expect($product->fresh()->stocks)->toBe(7);
        });

        it('validates movement fields', function () {
            $product = Product::factory()->create();

            $response = $this->actingAs($this->admin)->post(route('admin.products.movements.store', $product->id), [
                'movement_type' => '',
                'movement_category' => '',
                'quantity' => '',
                'movement_date' => '',
            ]);

            $response->assertSessionHasErrors(['movement_type', 'movement_category', 'quantity', 'movement_date']);
        });

        it('validates movement type is in or out', function () {
            $product = Product::factory()->create();

            $response = $this->actingAs($this->admin)->post(route('admin.products.movements.store', $product->id), [
                'movement_type' => 'adjustment',
                'movement_category' => 'damage',
                'quantity' => 1,
                'movement_date' => now()->format('Y-m-d'),
            ]);

            $response->assertSessionHasErrors(['movement_type']);
        });

        it('requires minimum quantity of 1', function () {
            $product = Product::factory()->create();

            $response = $this->actingAs($this->admin)->post(route('admin.products.movements.store', $product->id), [
                'movement_type' => 'in',
                'movement_category' => 'purchase_order',
                'quantity' => 0,
                'movement_date' => now()->format('Y-m-d'),
            ]);

            $response->assertSessionHasErrors(['quantity']);
        });
    });
});
