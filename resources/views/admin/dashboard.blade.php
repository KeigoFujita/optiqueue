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
        <select
            class="admin-input !w-auto !py-2 !px-3 !text-xs !rounded-lg bg-gray-50 border-gray-200 text-gray-600 cursor-pointer">
            <option value="today">Today</option>
            <option value="week" selected>This Week</option>
            <option value="month">This Month</option>
            <option value="year">This Year</option>
        </select>
        <button class="btn-primary !py-2 !px-4 !text-xs">
            <i class="fa-solid fa-download"></i>
            <span class="hidden sm:inline">Export</span>
        </button>
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8 space-y-8">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 stagger-children">

            <!-- Total Orders -->
            <div class="admin-card p-5 group cursor-pointer">
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-receipt text-blue-600 text-lg"></i>
                    </div>
                    <span class="badge badge-info text-[10px] px-2 py-0.5">
                        <i class="fa-solid fa-arrow-up mr-0.5"></i> +12%
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-0.5">1,284</div>
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
                        <i class="fa-solid fa-arrow-up mr-0.5"></i> +8.2%
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-0.5">$87,420</div>
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
                <div class="text-2xl font-bold text-gray-900 mb-0.5">Aurel</div>
                <div class="text-xs text-gray-500">Best Selling Frame</div>
                <div class="mt-3 flex items-center gap-1 text-amber-600 text-xs">
                    <i class="fa-solid fa-box"></i>
                    <span>248 units sold this month</span>
                </div>
            </div>

            <!-- Monthly Sales -->
            <div class="admin-card p-5 group cursor-pointer">
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-chart-line text-purple-600 text-lg"></i>
                    </div>
                    <span class="badge badge-neutral text-[10px] px-2 py-0.5">MTD</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-0.5">$24,650</div>
                <div class="text-xs text-gray-500">Monthly Sales Target</div>
                <div class="mt-3 flex items-center justify-between text-xs">
                    <span class="text-gray-400">73% of $33.8k goal</span>
                    <span class="font-semibold text-gray-700">$24.6k</span>
                </div>
                <div class="mt-1.5 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-[73%] bg-gradient-to-r from-purple-500 to-purple-600 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 stagger-children">

            <!-- Monthly Sales Line Chart -->
            <div class="admin-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold font-serif text-gray-900">Revenue Overview</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Monthly revenue for the last 6 months</p>
                    </div>
                    <span class="badge badge-neutral text-xs">+15.3% vs last period</span>
                </div>
                <div class="h-64">
                    <svg width="100%" height="100%" viewBox="0 0 800 260" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class="overflow-visible" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#0F3D2A" stop-opacity="0.15" />
                                <stop offset="100%" stop-color="#0F3D2A" stop-opacity="0" />
                            </linearGradient>
                            <filter id="shadow1">
                                <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#0F3D2A"
                                    flood-opacity="0.1" />
                            </filter>
                        </defs>
                        <!-- Grid lines -->
                        <line x1="60" y1="40" x2="760" y2="40" stroke="#f1f5f9"
                            stroke-width="1" />
                        <line x1="60" y1="95" x2="760" y2="95" stroke="#f1f5f9"
                            stroke-width="1" />
                        <line x1="60" y1="150" x2="760" y2="150" stroke="#f1f5f9"
                            stroke-width="1" />
                        <line x1="60" y1="205" x2="760" y2="205" stroke="#f1f5f9"
                            stroke-width="1" />
                        <!-- Gradient Area -->
                        <path d="M70,210 L70,185 L190,175 L320,120 L450,155 L580,80 L710,40 L710,210 Z"
                            fill="url(#areaGrad)" />
                        <!-- Line -->
                        <polyline points="70,185 190,175 320,120 450,155 580,80 710,40" stroke="#0F3D2A" stroke-width="3"
                            stroke-linecap="round" fill="none" class="chart-line" filter="url(#shadow1)" />
                        <!-- Data Dots -->
                        <circle cx="70" cy="185" r="5" fill="#0F3D2A" class="chart-dot" stroke="white"
                            stroke-width="2" />
                        <circle cx="190" cy="175" r="5" fill="#0F3D2A" class="chart-dot" stroke="white"
                            stroke-width="2" />
                        <circle cx="320" cy="120" r="5" fill="#0F3D2A" class="chart-dot" stroke="white"
                            stroke-width="2" />
                        <circle cx="450" cy="155" r="5" fill="#0F3D2A" class="chart-dot" stroke="white"
                            stroke-width="2" />
                        <circle cx="580" cy="80" r="5" fill="#0F3D2A" class="chart-dot" stroke="white"
                            stroke-width="2" />
                        <circle cx="710" cy="40" r="6" fill="#f4d03f" class="chart-dot" stroke="white"
                            stroke-width="2" />
                        <!-- Labels -->
                        <text x="70" y="235" fill="#94a3b8" font-size="11" text-anchor="middle"
                            font-family="Inter">Jan</text>
                        <text x="190" y="235" fill="#94a3b8" font-size="11" text-anchor="middle"
                            font-family="Inter">Feb</text>
                        <text x="320" y="235" fill="#94a3b8" font-size="11" text-anchor="middle"
                            font-family="Inter">Mar</text>
                        <text x="450" y="235" fill="#94a3b8" font-size="11" text-anchor="middle"
                            font-family="Inter">Apr</text>
                        <text x="580" y="235" fill="#94a3b8" font-size="11" text-anchor="middle"
                            font-family="Inter">May</text>
                        <text x="710" y="235" fill="#94a3b8" font-size="11" text-anchor="middle"
                            font-family="Inter">Jun</text>
                    </svg>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-[#0F3D2A]"></span>
                            Revenue
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-[#f4d03f]"></span>
                            Current
                        </span>
                    </div>
                    <span class="font-medium text-gray-700">+$12,430 vs last period</span>
                </div>
            </div>

            <!-- Weekly Orders Bar Chart -->
            <div class="admin-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold font-serif text-gray-900">Weekly Orders</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Order volume for the current week</p>
                    </div>
                    <span class="badge badge-neutral text-xs">Updated today</span>
                </div>
                <div class="h-64 flex items-end gap-3 px-1">
                    @php
                        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        $data = [65, 85, 45, 75, 35, 80, 55];
                        $maxH = 200;
                        $colors = ['#0F3D2A', '#1a5c3e', '#0F3D2A', '#1a5c3e', '#0F3D2A', '#f4d03f', '#e8b923'];
                    @endphp
                    @foreach ($days as $idx => $day)
                        @php
                            $h = ($data[$idx] / 100) * $maxH;
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="relative w-full max-w-[40px] rounded-lg transition-all duration-300 group-hover:brightness-110 group-hover:scale-y-105 group-hover:origin-bottom bar-chart flex items-end justify-center"
                                style="height: {{ $h }}px; animation: barGrow 0.6s cubic-bezier(0.16, 1, 0.3, 1) {{ $idx * 0.07 }}s both;">
                                <div class="w-full h-full rounded-lg"
                                    style="background: {{ $colors[$idx] }}; opacity: {{ $idx === 5 || $idx === 6 ? '0.85' : '0.65' }};">
                                </div>
                                <!-- Value tooltip on hover -->
                                <div
                                    class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] font-semibold px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                    {{ $data[$idx] }} orders
                                </div>
                            </div>
                            <span class="text-[11px] font-medium text-gray-500 mt-1">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-[#0F3D2A] opacity-65"></span>
                            Orders
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-[#f4d03f] opacity-85"></span>
                            Peak
                        </span>
                    </div>
                    <span class="font-medium text-gray-700">Avg. 63 orders/day</span>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Recent Orders + Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 stagger-children">

            <!-- Recent Orders -->
            <div class="admin-card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold font-serif text-gray-900">Recent Orders</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Latest 5 customer orders</p>
                    </div>
                    <a href="{{ route('admin.orders') }}"
                        class="text-xs font-medium text-[#0F3D2A] hover:text-[#f4d03f] transition-colors flex items-center gap-1">
                        View All
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                <div class="divide-y divide-gray-50">
                    @php
                        $recentOrders = [
                            ['#095401', 'Sarah Johnson', '$248.00', 'Ready', 'success'],
                            ['#095402', 'Mike Chen', '$186.00', 'Processing', 'info'],
                            ['#095403', 'Emma Wilson', '$324.00', 'Picked Up', 'neutral'],
                            ['#095404', 'James Brown', '$159.00', 'Processing', 'info'],
                            ['#095405', 'Lisa Davis', '$412.00', 'Cancelled', 'danger'],
                        ];
                    @endphp
                    @foreach ($recentOrders as $order)
                        <div class="px-6 py-3.5 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-semibold text-gray-500 shrink-0">
                                    <i class="fa-solid fa-receipt text-gray-400 text-xs"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $order[1] }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $order[0] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 shrink-0">
                                <span class="text-sm font-semibold text-gray-800">{{ $order[2] }}</span>
                                <span class="badge badge-{{ $order[4] }} text-[10px]">{{ $order[3] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="admin-card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold font-serif text-gray-900">Top Products</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Best performing this month</p>
                    </div>
                    <a href="{{ route('admin.products') }}"
                        class="text-xs font-medium text-[#0F3D2A] hover:text-[#f4d03f] transition-colors flex items-center gap-1">
                        Manage
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                <div class="divide-y divide-gray-50">
                    @php
                        $topProducts = [
                            ['Aurel Burgundy Gold', 'Frame', 248, 80, '$19,840'],
                            ['Kairo Matte Black', 'Frame', 186, 65, '$12,090'],
                            ['Transition Lens', 'Lens', 156, 55, '$7,800'],
                            ['Blue Lens', 'Lens', 134, 45, '$5,360'],
                            ['Luxe Case', 'Accessories', 89, 30, '$2,670'],
                        ];
                    @endphp
                    @foreach ($topProducts as $product)
                        <div class="px-6 py-3.5 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span class="text-xs font-bold text-gray-400 w-4">{{ $loop->iteration }}</span>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $product[0] }}</p>
                                    <span class="badge badge-neutral text-[9px] px-1.5 py-0">{{ $product[1] }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-800 shrink-0">{{ $product[4] }}</span>
                            </div>
                            <div class="flex items-center gap-3 ml-6">
                                <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-[#0F3D2A] to-[#f4d03f]"
                                        style="width: {{ $product[3] }}%">
                                    </div>
                                </div>
                                <span class="text-[11px] text-gray-500 w-16 text-right">{{ $product[2] }} units</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .admin-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .admin-card:hover {
                transform: translateY(-2px);
            }

            /* Chart line animation */
            .chart-line {
                stroke-dasharray: 800;
                stroke-dashoffset: 800;
                animation: drawLine 1.5s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
            }

            @keyframes drawLine {
                to {
                    stroke-dashoffset: 0;
                }
            }

            .chart-dot {
                opacity: 0;
                animation: dotAppear 0.3s ease 1.5s forwards;
            }

            @keyframes dotAppear {
                to {
                    opacity: 1;
                }
            }

            /* Bar chart animation */
            @keyframes barGrow {
                from {
                    transform: scaleY(0);
                    opacity: 0;
                }

                to {
                    transform: scaleY(1);
                    opacity: 1;
                }
            }

            .bar-chart {
                transform-origin: bottom;
                min-height: 8px;
            }
        </style>
    @endpush
@endsection
