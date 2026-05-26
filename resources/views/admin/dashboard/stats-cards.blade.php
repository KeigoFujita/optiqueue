<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 stagger-children" id="stats-cards">

    <!-- Total Orders -->
    <div class="admin-card p-5 group cursor-pointer">
        <div class="flex items-start justify-between mb-4">
            <div
                class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-receipt text-blue-600 text-lg"></i>
            </div>
            <span class="badge badge-info text-[10px] px-2 py-0.5">
                <i class="fa-solid fa-arrow-up mr-0.5"></i>
                {{ $ordersChange > 0 ? '+' : '' }}{{ $ordersChange }}%
            </span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-0.5" id="stat-total-orders">{{ number_format($totalOrders) }}</div>
        <div class="text-xs text-gray-500">Total Orders</div>
        <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full w-4/5 bg-blue-500 rounded-full"></div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="admin-card p-5 group cursor-pointer">
        <div class="flex items-start justify-between mb-4">
            <div
                class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-dollar-sign text-emerald-600 text-lg"></i>
            </div>
            <span class="badge badge-success text-[10px] px-2 py-0.5">
                <i class="fa-solid fa-arrow-up mr-0.5"></i>
                {{ $revenueChange > 0 ? '+' : '' }}{{ $revenueChange }}%
            </span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-0.5" id="stat-total-revenue">${{ number_format($totalRevenue, 2) }}</div>
        <div class="text-xs text-gray-500">Total Revenue</div>
        <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full w-3/5 bg-emerald-500 rounded-full"></div>
        </div>
    </div>

    <!-- Best Seller -->
    <div class="admin-card p-5 group cursor-pointer">
        <div class="flex items-start justify-between mb-4">
            <div
                class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-star text-amber-500 text-lg"></i>
            </div>
            <span class="badge badge-warning text-[10px] px-2 py-0.5">
                <i class="fa-solid fa-fire mr-0.5"></i> Trending
            </span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-0.5 truncate" id="stat-best-seller">{{ $bestSellerName }}</div>
        <div class="text-xs text-gray-500">Best Selling Frame</div>
        <div class="mt-3 flex items-center gap-1 text-amber-600 text-xs">
            <i class="fa-solid fa-box"></i>
            <span id="stat-best-seller-units">{{ number_format($bestSellerUnits) }} units sold</span>
        </div>
    </div>

    <!-- Monthly Sales Target -->
    <div class="admin-card p-5 group cursor-pointer">
        <div class="flex items-start justify-between mb-4">
            <div
                class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-chart-line text-purple-600 text-lg"></i>
            </div>
            <span class="badge badge-neutral text-[10px] px-2 py-0.5">MTD</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-0.5" id="stat-monthly-target">${{ number_format($monthlyTarget, 0) }}</div>
        <div class="text-xs text-gray-500">Monthly Sales Target</div>
        <div class="mt-3 flex items-center justify-between text-xs">
            <span class="text-gray-400" id="stat-target-label">{{ $salesProgressPercent }}% of ${{ number_format($monthlyTarget, 0) }} goal</span>
            <span class="font-semibold text-gray-700" id="stat-current-mtd">${{ number_format($currentMonthRevenue, 0) }}</span>
        </div>
        <div class="mt-1.5 h-1.5 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 rounded-full transition-all duration-500"
                id="stat-target-bar"
                style="width: {{ $salesProgressPercent }}%">
            </div>
        </div>
    </div>
</div>
