<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

beforeEach(function () {
    /** @var TestCase $this */
    $this->admin = User::factory()->create();
});

describe('DashboardDataController', function () {

    it('returns dashboard data as JSON with default week period', function () {
        Product::factory()->frame()->create();
        Order::factory()->create(['status' => 'processing', 'total_amount' => 1500]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard.data'));

        $response->assertOk();
        $response->assertJsonStructure([
            'stats' => [
                'totalOrders', 'totalRevenue', 'totalRevenueRaw',
                'bestSellerName', 'bestSellerUnits',
                'monthlyTarget', 'monthlyTargetRaw',
                'currentMonthRevenue', 'currentMonthRevenueRaw',
                'salesProgressPercent', 'revenueChange', 'ordersChange',
                'avgOrdersPerDay',
            ],
            'chartLabels', 'chartData', 'weekOrderData', 'topProducts',
        ]);
    });

    it('returns JSON with custom period', function () {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard.data', ['period' => 'year']));

        $response->assertOk();
        $response->assertJsonStructure(['stats', 'chartLabels', 'chartData', 'weekOrderData', 'topProducts']);
    });

});
