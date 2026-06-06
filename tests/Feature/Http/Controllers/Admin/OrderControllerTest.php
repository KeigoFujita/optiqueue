<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\OrderController;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

covers(OrderController::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->admin = User::factory()->create();
});

describe('OrderController', function () {

    describe('index()', function () {
        it('renders the orders page with all orders', function () {
            Order::factory(3)->create();

            $response = $this->actingAs($this->admin)->get(route('admin.orders'));

            $response->assertOk();
            $response->assertViewIs('admin.orders');
            $response->assertViewHasAll([
                'orders', 'totalOrders', 'pendingCount', 'processingCount',
                'readyCount', 'pickedUpCount', 'statusLabels',
            ]);
            expect($response->viewData('orders'))->toHaveCount(3);
        });

        it('filters orders by status', function () {
            Order::factory()->pending()->create();
            Order::factory()->processing()->create();
            Order::factory()->ready()->create();

            $response = $this->actingAs($this->admin)->get(route('admin.orders', ['status' => 'processing']));

            expect($response->viewData('orders'))->toHaveCount(1);
        });

        it('shows all orders when status is all', function () {
            Order::factory()->pending()->create();
            Order::factory()->ready()->create();

            $response = $this->actingAs($this->admin)->get(route('admin.orders', ['status' => 'all']));

            expect($response->viewData('orders'))->toHaveCount(2);
        });

        it('searches orders by order number', function () {
            Order::factory()->create(['order_no' => 'ORD-ABC123']);
            Order::factory()->create(['order_no' => 'ORD-XYZ789']);

            $response = $this->actingAs($this->admin)->get(route('admin.orders', ['search' => 'ABC']));

            expect($response->viewData('orders'))->toHaveCount(1);
            expect($response->viewData('orders')->first()->order_no)->toBe('ORD-ABC123');
        });

        it('handles empty orders', function () {
            $response = $this->actingAs($this->admin)->get(route('admin.orders'));

            expect($response->viewData('totalOrders'))->toBe(0);
            expect($response->viewData('orders'))->toHaveCount(0);
        });
    });

    describe('show()', function () {
        it('returns order details as JSON', function () {
            $order = Order::factory()->create();

            $response = $this->actingAs($this->admin)->get(route('admin.orders.show', $order->id));

            $response->assertOk();
            $response->assertJson([
                'success' => true,
            ]);
            $response->assertJsonStructure([
                'success',
                'order' => ['id', 'order_no', 'status', 'total_amount', 'created_at', 'customer', 'items_html'],
            ]);
        });

        it('returns 404 for non-existent order', function () {
            $response = $this->actingAs($this->admin)->get(route('admin.orders.show', 99999));

            $response->assertNotFound();
        });
    });

    describe('updateStatus()', function () {
        beforeEach(function () {
            Mail::fake();
        });

        it('updates order status from pending to processing', function () {
            $order = Order::factory()->pending()->create();

            $response = $this->actingAs($this->admin)->put(route('admin.orders.updateStatus', $order->id), [
                'status' => 'processing',
            ]);

            $response->assertOk();
            $response->assertJson([
                'success' => true,
                'order' => ['id' => $order->id, 'status' => 'processing'],
            ]);
            expect($order->fresh()->status)->toBe('processing');
            Mail::assertSent(OrderStatusMail::class);
        });

        it('updates order status from processing to ready', function () {
            $order = Order::factory()->processing()->create();

            $response = $this->actingAs($this->admin)->put(route('admin.orders.updateStatus', $order->id), [
                'status' => 'ready',
            ]);

            $response->assertOk();
            expect($order->fresh()->status)->toBe('ready');
        });

        it('rejects updates on picked-up orders', function () {
            $order = Order::factory()->pickedUp()->create();

            $response = $this->actingAs($this->admin)->put(route('admin.orders.updateStatus', $order->id), [
                'status' => 'pending',
            ]);

            $response->assertStatus(422);
            $response->assertJson([
                'success' => false,
            ]);
            expect($order->fresh()->status)->toBe('picked-up');
            Mail::assertNotSent(OrderStatusMail::class);
        });

        it('rejects updates on cancelled orders', function () {
            $order = Order::factory()->cancelled()->create();

            $response = $this->actingAs($this->admin)->put(route('admin.orders.updateStatus', $order->id), [
                'status' => 'pending',
            ]);

            $response->assertStatus(422);
            expect($order->fresh()->status)->toBe('cancelled');
        });

        it('returns 404 for non-existent order', function () {
            $response = $this->actingAs($this->admin)->put(route('admin.orders.updateStatus', 99999), [
                'status' => 'processing',
            ]);

            $response->assertNotFound();
        });

        it('validates status field', function () {
            $order = Order::factory()->create();

            $response = $this->actingAs($this->admin)->put(route('admin.orders.updateStatus', $order->id), [
                'status' => 'invalid-status',
            ]);

            $response->assertSessionHasErrors(['status']);
        });

        it('requires a valid status value', function () {
            $order = Order::factory()->create();

            $response = $this->actingAs($this->admin)->put(route('admin.orders.updateStatus', $order->id), [
                'status' => '',
            ]);

            $response->assertSessionHasErrors(['status']);
        });
    });
});
