<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

beforeEach(function () {
    /** @var TestCase $this */
    $this->admin = User::factory()->create();
});

describe('DashboardController', function () {

    it('renders the dashboard with default week period', function () {
        Product::factory(2)->frame()->create();
        Order::factory(2)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHasAll([
            'totalOrders', 'totalRevenue', 'bestSellerName', 'bestSellerUnits',
            'monthlyTarget', 'currentMonthRevenue', 'salesProgressPercent',
            'chartLabels', 'chartData', 'weekOrderData', 'avgOrdersPerDay',
            'recentOrders', 'topProducts', 'revenueChange', 'ordersChange',
        ]);
    });

    it('accepts a custom period parameter', function () {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard', ['period' => 'month']));

        $response->assertOk();
        expect($response->viewData('period'))->toBe('month');
    });

    it('handles today period', function () {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard', ['period' => 'today']));

        $response->assertOk();
        expect($response->viewData('period'))->toBe('today');
    });

    it('requires authentication', function () {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    });
});
