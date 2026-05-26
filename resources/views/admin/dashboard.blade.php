@extends('layouts.admin')

@section('title', 'Admin Dashboard - Optiqueue')

@section('page-header')
    <div>
        <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">Dashboard</h2>
        <p class="text-sm text-gray-500 mt-0.5">Welcome back, Admin &mdash; here's what's happening today.</p>
    </div>
@endsection

@section('header-actions')
    <div class="flex items-center gap-2">
        <span class="text-xs text-gray-400 flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            Live
        </span>
        <select id="period-filter"
            class="admin-input !w-auto !py-2 !px-3 !text-xs !rounded-lg bg-gray-50 border-gray-200 text-gray-600 cursor-pointer">
            <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Today</option>
            <option value="week" {{ $period === 'week' ? 'selected' : '' }}>This Week</option>
            <option value="month" {{ $period === 'month' ? 'selected' : '' }}>This Month</option>
            <option value="year" {{ $period === 'year' ? 'selected' : '' }}>This Year</option>
        </select>
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8 space-y-8">

        <!-- Stats Cards -->
        @include('admin.dashboard.stats-cards', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'bestSellerName' => $bestSellerName,
            'bestSellerUnits' => $bestSellerUnits,
            'monthlyTarget' => $monthlyTarget,
            'currentMonthRevenue' => $currentMonthRevenue,
            'salesProgressPercent' => $salesProgressPercent,
            'revenueChange' => $revenueChange,
            'ordersChange' => $ordersChange,
        ])

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 stagger-children">
            @include('admin.dashboard.revenue-chart', [
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
            ])
            @include('admin.dashboard.weekly-orders', [
                'weekDays' => $weekDays,
                'weekOrderData' => $weekOrderData,
                'avgOrdersPerDay' => $avgOrdersPerDay,
            ])
        </div>

        <!-- Bottom Row: Recent Orders + Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 stagger-children">
            @include('admin.dashboard.recent-orders', ['recentOrders' => $recentOrders])
            @include('admin.dashboard.top-products', ['topProducts' => $topProducts])
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const periodFilter = document.getElementById('period-filter');

                if (periodFilter) {
                    periodFilter.addEventListener('change', function () {
                        const period = this.value;
                        const url = new URL(window.location.href);
                        url.searchParams.set('period', period);
                        window.location.href = url.toString();
                    });
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .admin-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .admin-card:hover {
                transform: translateY(-2px);
            }
        </style>
    @endpush
@endsection
