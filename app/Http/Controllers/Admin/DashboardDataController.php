<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardDataController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $data = $this->dashboardService->getStats($request->query('period', 'week'));

        $topProductsJson = $data['topProducts']->map(function ($item) {
            return [
                'name' => $item->product->name,
                'type' => $item->product->type,
                'units' => (int) $item->total_qty,
                'revenue' => '$'.number_format((float) $item->total_revenue, 2),
            ];
        });

        return response()->json([
            'stats' => [
                'totalOrders' => $data['totalOrders'],
                'totalRevenue' => '$'.number_format($data['totalRevenue'], 2),
                'totalRevenueRaw' => $data['totalRevenue'],
                'bestSellerName' => $data['bestSellerName'],
                'bestSellerUnits' => $data['bestSellerUnits'],
                'monthlyTarget' => '$'.number_format($data['monthlyTarget'], 0),
                'monthlyTargetRaw' => $data['monthlyTarget'],
                'currentMonthRevenue' => '$'.number_format($data['currentMonthRevenue'], 0),
                'currentMonthRevenueRaw' => $data['currentMonthRevenue'],
                'salesProgressPercent' => $data['salesProgressPercent'],
                'revenueChange' => $data['revenueChange'],
                'ordersChange' => $data['ordersChange'],
                'avgOrdersPerDay' => $data['avgOrdersPerDay'],
            ],
            'chartLabels' => $data['chartLabels'],
            'chartData' => $data['chartData'],
            'weekOrderData' => $data['weekOrderData'],
            'topProducts' => $topProductsJson,
        ]);
    }
}
