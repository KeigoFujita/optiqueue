<?php

declare(strict_types=1);

use App\Models\User;
use Tests\TestCase;

describe('Authenticate middleware', function () {

    describe('guest access', function () {
        it('redirects unauthenticated GET requests to the login page')
            ->with([
                '/admin/dashboard',
                '/admin/orders',
                '/admin/orders/1',
                '/admin/products',
                '/admin/inventory',
                '/admin/products/1/edit',
                '/admin/products/1/movements',
            ])
            ->expect(fn ($url) => $this->get($url)
                ->assertRedirect('/admin/login'));

        it('redirects unauthenticated POST requests to the login page')
            ->with([
                '/admin/logout',
                '/admin/products',
                '/admin/products/1/movements',
            ])
            ->expect(fn ($url) => $this->post($url)
                ->assertRedirect('/admin/login'));

        it('redirects unauthenticated PUT requests to the login page')
            ->with([
                '/admin/products/1',
                '/admin/orders/1/status',
            ])
            ->expect(fn ($url) => $this->put($url)
                ->assertRedirect('/admin/login'));
    });

    describe('authenticated access', function () {
        it('allows authenticated users through the middleware', function () {
            /** @var TestCase $this */
            $admin = User::factory()->create();

            $response = $this->actingAs($admin)->get(route('admin.dashboard'));
            $response->assertOk();
        });
    });

});
