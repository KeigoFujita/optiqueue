<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function resolveDateRange(string $period): array
    {
        $now = Carbon::now();

        return match ($period) {
            'today' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'week' => [$now->copy()->startOfWeek(Carbon::MONDAY), $now->copy()->endOfDay()],
            'month' => [$now->copy()->startOfMonth(), $now->copy()->endOfDay()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfDay()],
            default => [$now->copy()->startOfWeek(Carbon::MONDAY), $now->copy()->endOfDay()],
        };
    }

    public function getStats(string $period): array
    {
        [$startDate, $endDate] = $this->resolveDateRange($period);

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        $totalRevenue = (float) Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->sum('total_amount');

        $bestSeller = OrderDetail::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereNotIn('status', ['cancelled', 'pending']);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->first();

        $monthlyRevenue = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as revenue')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        $chartLabels = [];
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $chartLabels[] = Carbon::now()->subMonths($i)->format('M');
            $chartData[] = (float) ($monthlyRevenue[$month] ?? 0);
        }

        $salesTrend = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as revenue')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        $trendValues = $salesTrend->values()->toArray();
        $monthCount = count($trendValues);
        $monthlyTarget = 0;

        if ($monthCount >= 2) {
            $x = range(1, $monthCount);
            $y = $trendValues;
            $n = $monthCount;
            $sumX = array_sum($x);
            $sumY = array_sum($y);
            $sumXY = 0;
            $sumX2 = 0;
            for ($i = 0; $i < $n; $i++) {
                $sumXY += $x[$i] * $y[$i];
                $sumX2 += $x[$i] * $x[$i];
            }
            $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
            $intercept = ($sumY - $slope * $sumX) / $n;
            $monthlyTarget = max(0, $slope * ($monthCount + 1) + $intercept);
        } elseif ($monthCount === 1) {
            $monthlyTarget = $trendValues[0] * 1.1;
        }

        $currentMonthRevenue = (float) Order::where('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->sum('total_amount');

        $salesProgressPercent = $monthlyTarget > 0
            ? min(100, round(($currentMonthRevenue / $monthlyTarget) * 100))
            : 0;

        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $weekEnd = Carbon::now()->endOfDay();

        $dailyOrders = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $weekOrderData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i)->format('Y-m-d');
            $weekOrderData[] = (int) ($dailyOrders[$date] ?? 0);
        }
        $daysWithOrders = array_filter($weekOrderData, fn ($v) => $v > 0);
        $avgOrdersPerDay = count($daysWithOrders) > 0
            ? round(array_sum($weekOrderData) / count($daysWithOrders), 1)
            : 0;

        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $topProducts = OrderDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_qty'),
            DB::raw('SUM(quantity * products.price) as total_revenue')
        )
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->whereHas('order', function ($q) {
                $q->where('created_at', '>=', Carbon::now()->startOfMonth())
                    ->whereNotIn('status', ['cancelled', 'pending']);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('product')
            ->get();

        $periodDuration = $endDate->diffInSeconds($startDate) + 1;
        $prevEndDate = $startDate->copy()->subSecond();
        $prevStartDate = $prevEndDate->copy()->subSeconds($periodDuration)->addSecond();

        $prevPeriodRevenue = (float) Order::whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->sum('total_amount');

        $prevPeriodOrders = Order::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();

        $revenueChange = $prevPeriodRevenue > 0
            ? round((($totalRevenue - $prevPeriodRevenue) / $prevPeriodRevenue) * 100, 1)
            : 100;

        $ordersChange = $prevPeriodOrders > 0
            ? round((($totalOrders - $prevPeriodOrders) / $prevPeriodOrders) * 100, 1)
            : 100;

        $bestSellerUnits = $bestSeller ? (int) $bestSeller->total_qty : 0;
        $bestSellerName = $bestSeller?->product?->name ?? 'N/A';

        return compact(
            'period',
            'totalOrders',
            'totalRevenue',
            'bestSellerName',
            'bestSellerUnits',
            'monthlyTarget',
            'currentMonthRevenue',
            'salesProgressPercent',
            'chartLabels',
            'chartData',
            'weekDays',
            'weekOrderData',
            'avgOrdersPerDay',
            'recentOrders',
            'topProducts',
            'revenueChange',
            'ordersChange',
        );
    }
}
