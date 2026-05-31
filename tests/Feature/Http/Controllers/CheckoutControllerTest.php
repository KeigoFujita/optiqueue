<?php

use App\Mail\OrderConfirmationMail;
use App\Mail\OtpMail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\Support\Facades\Mail;

describe('CheckoutController', function () {

    describe('index()', function () {
        it('accepts a valid product query parameter', function () {
            $product = Product::factory()->frame()->create(['price' => 1500]);
            Product::factory(2)->lens()->create();
            Product::factory(2)->accessory()->create();

            $response = $this->get(route('checkout', ['product' => $product->id]));

            $response->assertOk();
            expect($response->viewData('product')->id)->toBe($product->id);
        });

        it('redirects to home when no product parameter is provided', function () {
            $response = $this->get(route('checkout'));

            $response->assertRedirect(route('home'));
        });

        it('redirects to home when product parameter is missing', function () {
            $response = $this->get(route('checkout', ['product' => '']));

            $response->assertRedirect(route('home'));
        });

        it('redirects to home for an inactive product', function () {
            $product = Product::factory()->inactive()->create();

            $response = $this->get(route('checkout', ['product' => $product->id]));

            $response->assertRedirect(route('home'));
        });

        it('redirects to home for a non-existent product', function () {
            $response = $this->get(route('checkout', ['product' => 99999]));

            $response->assertRedirect(route('home'));
        });
    });

    describe('placeOrder()', function () {
        it('returns place-order page with no products selected', function () {
            $response = $this->get(route('order.place'));

            $response->assertOk();
            $response->assertViewIs('place-order');
            expect($response->viewData('frame'))->toBeNull();
            expect($response->viewData('lens'))->toBeNull();
            expect($response->viewData('accessory'))->toBeNull();
            expect($response->viewData('total'))->toBe(0);
        });

        it('calculates price with a single frame', function () {
            $frame = Product::factory()->frame()->create(['price' => 2500]);

            $response = $this->get(route('order.place', ['frame_id' => $frame->id]));

            $response->assertOk();
            expect($response->viewData('framePrice'))->toBe(2500);
            expect($response->viewData('total'))->toBe(2500);
        });

        it('calculates total with frame, lens, and accessory', function () {
            $frame = Product::factory()->frame()->create(['price' => 2500]);
            $lens = Product::factory()->lens()->create(['price' => 800]);
            $accessory = Product::factory()->accessory()->create(['price' => 350]);

            $response = $this->get(route('order.place', [
                'frame_id' => $frame->id,
                'lens_id' => $lens->id,
                'accessory_id' => $accessory->id,
            ]));

            $response->assertOk();
            expect($response->viewData('framePrice'))->toBe(2500);
            expect($response->viewData('lensPrice'))->toBe(800);
            expect($response->viewData('accessoryPrice'))->toBe(350);
            expect($response->viewData('total'))->toBe(3650);
        });

        it('treats missing products as zero price', function () {
            $response = $this->get(route('order.place', ['frame_id' => 99999]));

            $response->assertOk();
            expect($response->viewData('frame'))->toBeNull();
            expect($response->viewData('framePrice'))->toBe(0);
            expect($response->viewData('total'))->toBe(0);
        });
    });

    describe('sendOtp()', function () {
        beforeEach(function () {
            Mail::fake();
        });

        it('creates a new customer and sends OTP email', function () {
            $response = $this->post(route('order.sendOtp'), [
                'email' => 'john@example.com',
            ]);

            $response->assertOk();
            $response->assertJson([
                'success' => true,
                'message' => 'OTP sent successfully.',
            ]);

            $customer = Customer::where('email', 'john@example.com')->first();
            expect($customer)->not->toBeNull();
            expect($customer->name)->toBeNull();
            expect($customer->otp)->not->toBeNull();
            expect($customer->otp_expires_at)->not->toBeNull();

            Mail::assertSent(OtpMail::class, function ($mail) {
                return $mail->hasTo('john@example.com');
            });
        });

        it('updates existing customer OTP on repeated requests', function () {
            $customer = Customer::factory()->create([
                'email' => 'jane@example.com',
                'otp' => '000000',
                'otp_expires_at' => now()->subHour(),
            ]);

            $response = $this->post(route('order.sendOtp'), [
                'email' => 'jane@example.com',
            ]);

            $response->assertOk();
            $customer->refresh();
            expect($customer->otp)->not->toBe('000000');
            expect($customer->otp_expires_at)->toBeGreaterThan(now());
        });

        it('requires a valid email', function () {
            $response = $this->post(route('order.sendOtp'), [
                'email' => '',
            ]);

            $response->assertSessionHasErrors(['email']);
        });
    });

    describe('resendOtp()', function () {
        beforeEach(function () {
            Mail::fake();
        });

        it('resends OTP for an existing customer', function () {
            Customer::factory()->create([
                'email' => 'alice@example.com',
                'otp' => '000000',
                'otp_expires_at' => now()->subHour(),
            ]);

            $response = $this->post(route('order.resendOtp'), [
                'email' => 'alice@example.com',
            ]);

            $response->assertOk();
            $response->assertJson([
                'success' => true,
                'message' => 'New OTP sent successfully.',
            ]);

            $customer = Customer::where('email', 'alice@example.com')->first();
            expect($customer->otp)->not->toBe('000000');
            expect($customer->otp_expires_at)->toBeGreaterThan(now());

            Mail::assertSent(OtpMail::class);
        });

        it('returns 404 for an unknown email', function () {
            $response = $this->post(route('order.resendOtp'), [
                'email' => 'unknown@example.com',
            ]);

            $response->assertNotFound();
            $response->assertJson([
                'success' => false,
                'message' => 'Email not found. Please verify your email first.',
            ]);
        });

        it('requires a valid email', function () {
            $response = $this->post(route('order.resendOtp'), [
                'email' => '',
            ]);

            $response->assertSessionHasErrors(['email']);
        });
    });

    describe('verifyOtp()', function () {
        it('verifies a customer with a valid OTP', function () {
            Customer::factory()->create([
                'email' => 'john@example.com',
                'otp' => '123456',
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            $response = $this->post(route('order.verifyOtp'), [
                'email' => 'john@example.com',
                'otp' => '123456',
            ]);

            $response->assertOk();
            $response->assertJson([
                'success' => true,
                'message' => 'OTP verified successfully.',
            ]);

            $customer = Customer::where('email', 'john@example.com')->first();
            expect($customer->verified_at)->not->toBeNull();
            expect($customer->otp)->toBeNull();
            expect($customer->otp_expires_at)->toBeNull();
        });

        it('rejects an invalid OTP', function () {
            Customer::factory()->create([
                'email' => 'john@example.com',
                'otp' => '123456',
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            $response = $this->post(route('order.verifyOtp'), [
                'email' => 'john@example.com',
                'otp' => '999999',
            ]);

            $response->assertStatus(422);
            $response->assertJson([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.',
            ]);
        });

        it('rejects an expired OTP', function () {
            Customer::factory()->create([
                'email' => 'john@example.com',
                'otp' => '123456',
                'otp_expires_at' => now()->subMinutes(5),
            ]);

            $response = $this->post(route('order.verifyOtp'), [
                'email' => 'john@example.com',
                'otp' => '123456',
            ]);

            $response->assertStatus(422);
            $response->assertJson([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.',
            ]);
        });

        it('returns 404 for an unknown email', function () {
            $response = $this->post(route('order.verifyOtp'), [
                'email' => 'unknown@example.com',
                'otp' => '123456',
            ]);

            $response->assertNotFound();
            $response->assertJson([
                'success' => false,
                'message' => 'Email not found.',
            ]);
        });

        it('validates required fields', function () {
            $response = $this->post(route('order.verifyOtp'), [
                'email' => '',
                'otp' => '',
            ]);

            $response->assertSessionHasErrors(['email', 'otp']);
        });

        it('validates OTP length must be 6', function () {
            $response = $this->post(route('order.verifyOtp'), [
                'email' => 'john@example.com',
                'otp' => '123',
            ]);

            $response->assertSessionHasErrors(['otp']);
        });
    });

    describe('storeOrder()', function () {
        beforeEach(function () {
            Mail::fake();
        });

        it('creates an order with a frame product', function () {
            $customer = Customer::factory()->verified()->create(['email' => 'john@example.com']);
            $frame = Product::factory()->frame()->create(['price' => 1500, 'stocks' => 10]);

            $response = $this->post(route('order.store'), [
                'email' => 'john@example.com',
                'name' => 'John Doe',
                'contact' => '09171234567',
                'frame_id' => $frame->id,
            ]);

            $response->assertOk();
            $response->assertJsonStructure([
                'success',
                'message',
                'order_no',
            ]);

            $order = $customer->orders()->first();
            expect($order)->not->toBeNull();
            expect($order->total_amount)->toEqual(1500);
            expect($order->status)->toBe('pending');

            expect($order->orderDetails()->count())->toBe(1);

            $frame->refresh();
            expect($frame->stocks)->toBe(9);

            expect(ProductMovement::where('reference_id', $order->order_no)->count())->toBe(1);

            Mail::assertSent(OrderConfirmationMail::class);
        });

        it('creates an order with frame, lens, and accessory', function () {
            $customer = Customer::factory()->verified()->create(['email' => 'jane@example.com']);
            $frame = Product::factory()->frame()->create(['price' => 2500, 'stocks' => 5]);
            $lens = Product::factory()->lens()->create(['price' => 800, 'stocks' => 5]);
            $accessory = Product::factory()->accessory()->create(['price' => 350, 'stocks' => 5]);

            $response = $this->post(route('order.store'), [
                'email' => 'jane@example.com',
                'name' => 'Jane Doe',
                'contact' => '09876543210',
                'frame_id' => $frame->id,
                'lens_id' => $lens->id,
                'accessory_id' => $accessory->id,
            ]);

            $response->assertOk();

            $order = $customer->orders()->first();
            expect($order)->not->toBeNull();
            expect($order->total_amount)->toEqual(3650);

            expect($order->orderDetails()->count())->toBe(3);

            $frame->refresh();
            $lens->refresh();
            $accessory->refresh();
            expect($frame->stocks)->toBe(4);
            expect($lens->stocks)->toBe(4);
            expect($accessory->stocks)->toBe(4);

            expect(ProductMovement::count())->toBe(3);
        });

        it('rejects an unverified customer', function () {
            Customer::factory()->create([
                'email' => 'unverified@example.com',
                'verified_at' => null,
            ]);
            $frame = Product::factory()->frame()->create(['stocks' => 5]);

            $response = $this->post(route('order.store'), [
                'email' => 'unverified@example.com',
                'name' => 'Test User',
                'contact' => '09170000000',
                'frame_id' => $frame->id,
            ]);

            $response->assertStatus(422);
            $response->assertJson([
                'success' => false,
                'message' => 'Email not verified. Please verify your email first.',
            ]);
        });

        it('returns 500 for missing customer when email does not exist', function () {
            $response = $this->post(route('order.store'), [
                'email' => 'ghost@example.com',
                'name' => 'Ghost',
                'contact' => '09170000000',
            ]);

            $response->assertStatus(500);
            $response->assertJson([
                'success' => false,
            ]);
        });

        it('handles insufficient stock gracefully', function () {
            Customer::factory()->verified()->create(['email' => 'buyer@example.com']);
            $frame = Product::factory()->frame()->create(['price' => 1000, 'stocks' => 0]);

            $response = $this->post(route('order.store'), [
                'email' => 'buyer@example.com',
                'name' => 'Buyer',
                'contact' => '09170000001',
                'frame_id' => $frame->id,
            ]);

            $response->assertStatus(500);
            $response->assertJson([
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
            ]);

            $frame->refresh();
            expect($frame->stocks)->toBe(0);

            Mail::assertNotSent(OrderConfirmationMail::class);
        });

        it('validates required fields', function () {
            $response = $this->post(route('order.store'), [
                'email' => '',
                'name' => '',
                'contact' => '',
            ]);

            $response->assertSessionHasErrors(['email', 'name', 'contact']);
        });
    });
});
