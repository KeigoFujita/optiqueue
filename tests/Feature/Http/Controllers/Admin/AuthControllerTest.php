<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AuthController;
use App\Models\User;

covers(AuthController::class);

describe('AuthController', function () {

    describe('showLoginForm()', function () {
        it('returns the login page', function () {
            $response = $this->get(route('admin.login'));

            $response->assertOk();
            $response->assertViewIs('admin.login');
        });
    });

    describe('login()', function () {
        it('authenticates admin with valid credentials', function () {
            User::factory()->create([
                'email' => 'admin@optiqueue.com',
                'password' => bcrypt('password'),
            ]);

            $response = $this->post(route('admin.login.submit'), [
                'email' => 'admin@optiqueue.com',
                'password' => 'password',
            ]);

            $response->assertRedirect(route('admin.dashboard'));
            $this->assertAuthenticated();
        });

        it('rejects invalid credentials', function () {
            User::factory()->create([
                'email' => 'admin@optiqueue.com',
                'password' => bcrypt('password'),
            ]);

            $response = $this->post(route('admin.login.submit'), [
                'email' => 'admin@optiqueue.com',
                'password' => 'wrong-password',
            ]);

            $response->assertSessionHasErrors(['email']);
            $this->assertGuest();
        });

        it('validates required fields', function () {
            $response = $this->post(route('admin.login.submit'), [
                'email' => '',
                'password' => '',
            ]);

            $response->assertSessionHasErrors(['email', 'password']);
        });

        it('validates email format', function () {
            $response = $this->post(route('admin.login.submit'), [
                'email' => 'not-an-email',
                'password' => 'password',
            ]);

            $response->assertSessionHasErrors(['email']);
        });
    });

    describe('logout()', function () {
        it('logs out the admin and redirects to login', function () {
            $admin = User::factory()->create();

            $response = $this->actingAs($admin)->post(route('admin.logout'));

            $response->assertRedirect(route('admin.login'));
            $this->assertGuest();
        });

    });
});
