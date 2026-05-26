<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductMovement;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm(): View
    {
        return view('admin.login');
    }

    /**
     * Authenticate the admin user.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the admin user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Resolve date range from a period key.
     */
    private function resolveDateRange(string $period): array
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

    /**
     * Dashboard: overview stats, charts, and recent data.
     */
    public function dashboard(Request $request): View
    {
        $period = $request->query('period', 'week');
        [$startDate, $endDate] = $this->resolveDateRange($period);

        // ── Stats Cards ────────────────────────────────────────────────
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        $totalRevenue = (float) Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->sum('total_amount');

        // Best selling product for the period
        $bestSeller = OrderDetail::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereNotIn('status', ['cancelled', 'pending']);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->first();

        // ── Monthly Revenue Data (last 12 months) ──────────────────────
        $monthlyRevenue = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as revenue')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        // Fill in missing months with zero
        $chartLabels = [];
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $chartLabels[] = Carbon::now()->subMonths($i)->format('M');
            $chartData[] = (float) ($monthlyRevenue[$month] ?? 0);
        }

        // ── Monthly Sales Target (based on trend) ──────────────────────
        $salesTrend = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as revenue')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        // Simple linear regression for trend-based target
        $trendValues = $salesTrend->values()->toArray();
        $monthCount = count($trendValues);
        $monthlyTarget = 0;

        if ($monthCount >= 2) {
            // Linear regression: y = mx + b
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
            // Forecast next month
            $monthlyTarget = max(0, $slope * ($monthCount + 1) + $intercept);
        } elseif ($monthCount === 1) {
            $monthlyTarget = $trendValues[0] * 1.1; // 10% increase as baseline
        }

        // Current month sales
        $currentMonthRevenue = (float) Order::where('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereNotIn('status', ['cancelled', 'pending'])
            ->sum('total_amount');

        $salesProgressPercent = $monthlyTarget > 0
            ? min(100, round(($currentMonthRevenue / $monthlyTarget) * 100))
            : 0;

        // ── Weekly Order Data ──────────────────────────────────────────
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

        // ── Recent Orders (latest 5) ───────────────────────────────────
        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // ── Top Selling Products (current month) ───────────────────────
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

        // ── Comparison with previous period ────────────────────────────
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

        // ── Best seller units this period ──────────────────────────────
        $bestSellerUnits = $bestSeller ? (int) $bestSeller->total_qty : 0;
        $bestSellerName = $bestSeller?->product?->name ?? 'N/A';

        return view('admin.dashboard', compact(
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
        ));
    }

    /**
     * AJAX endpoint to refresh dashboard data for a given period.
     */
    public function dashboardData(Request $request): JsonResponse
    {
        $period = $request->query('period', 'week');
        [$startDate, $endDate] = $this->resolveDateRange($period);

        // Stats
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

        // Monthly revenue for chart (last 12 months)
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

        // Monthly sales target (trend-based)
        $salesTrend = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as revenue')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->where('status', '!=', 'cancelled')
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
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $salesProgressPercent = $monthlyTarget > 0
            ? min(100, round(($currentMonthRevenue / $monthlyTarget) * 100))
            : 0;

        // Weekly order data
        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $dailyOrders = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$weekStart, Carbon::now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $weekOrderData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i)->format('Y-m-d');
            $weekOrderData[] = (int) ($dailyOrders[$date] ?? 0);
        }
        $daysWithOrders = array_filter($weekOrderData, fn ($v) => $v > 0);
        $avgOrdersPerDay = count($daysWithOrders) > 0
            ? round(array_sum($weekOrderData) / count($daysWithOrders), 1)
            : 0;

        // Comparison
        $periodDuration = $endDate->diffInSeconds($startDate) + 1;
        $prevEndDate = $startDate->copy()->subSecond();
        $prevStartDate = $prevEndDate->copy()->subSeconds($periodDuration)->addSecond();

        $prevPeriodRevenue = (float) Order::whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $prevPeriodOrders = Order::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();

        $revenueChange = $prevPeriodRevenue > 0
            ? round((($totalRevenue - $prevPeriodRevenue) / $prevPeriodRevenue) * 100, 1)
            : 100;

        $ordersChange = $prevPeriodOrders > 0
            ? round((($totalOrders - $prevPeriodOrders) / $prevPeriodOrders) * 100, 1)
            : 100;

        // Top products
        $topProductsData = OrderDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_qty'),
            DB::raw('SUM(quantity * products.price) as total_revenue')
        )
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->whereHas('order', function ($q) {
                $q->where('created_at', '>=', Carbon::now()->startOfMonth())
                    ->where('status', '!=', 'cancelled');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('product')
            ->get();

        $topProductsJson = $topProductsData->map(function ($item) {
            return [
                'name' => $item->product->name,
                'type' => $item->product->type,
                'units' => (int) $item->total_qty,
                'revenue' => '$'.number_format((float) $item->total_revenue, 2),
            ];
        });

        return response()->json([
            'stats' => [
                'totalOrders' => $totalOrders,
                'totalRevenue' => '$'.number_format($totalRevenue, 2),
                'totalRevenueRaw' => $totalRevenue,
                'bestSellerName' => $bestSeller?->product?->name ?? 'N/A',
                'bestSellerUnits' => (int) ($bestSeller?->total_qty ?? 0),
                'monthlyTarget' => '$'.number_format($monthlyTarget, 0),
                'monthlyTargetRaw' => $monthlyTarget,
                'currentMonthRevenue' => '$'.number_format($currentMonthRevenue, 0),
                'currentMonthRevenueRaw' => $currentMonthRevenue,
                'salesProgressPercent' => $salesProgressPercent,
                'revenueChange' => $revenueChange,
                'ordersChange' => $ordersChange,
                'avgOrdersPerDay' => $avgOrdersPerDay ?? 0,
            ],
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'weekOrderData' => $weekOrderData,
            'topProducts' => $topProductsJson,
        ]);
    }

    /**
     * Show the inventory page with stock summaries, low-stock alerts,
     * and the most recent product movements.
     */
    public function inventory(): View
    {
        $products = Product::all();

        $totalFrames = $products->where('type', 'frame')->sum('stocks');
        $totalLenses = $products->where('type', 'lens')->sum('stocks');
        $totalAccessories = $products->where('type', 'accessory')->sum('stocks');
        $totalItems = $products->sum('stocks');

        $lowStockProducts = $products->where('stocks', '<', 20);

        $movements = ProductMovement::with('product')
            ->orderBy('movement_date', 'desc')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return view('admin.inventory', compact(
            'products', 'totalFrames', 'totalLenses', 'totalAccessories', 'totalItems',
            'lowStockProducts', 'movements'
        ));
    }
}
