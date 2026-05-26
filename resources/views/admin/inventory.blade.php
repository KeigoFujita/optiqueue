@extends('layouts.admin')

@section('title', 'Inventory - Products Movement | Optiqueue')

@section('page-header')
    <div>
        <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">Inventory</h2>
        <p class="text-sm text-gray-500 mt-0.5">Track products movement and stock levels</p>
    </div>
@endsection

@section('header-actions')
    <div class="flex items-center gap-3">
        <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-1.5 border border-gray-200">
            <i class="fa-solid fa-calendar text-gray-400 text-xs"></i>
            <select class="bg-transparent border-0 text-sm text-gray-600 focus:outline-none cursor-pointer py-1">
                <option value="05/2026" selected>May 2026</option>
                <option value="04/2026">April 2026</option>
                <option value="03/2026">March 2026</option>
            </select>
        </div>
        <button class="btn-dark !py-2 !px-4 !text-xs !rounded-xl">
            <i class="fa-solid fa-print"></i>
            <span class="hidden sm:inline">Report</span>
        </button>
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8 space-y-6">

        <!-- Stock Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 stagger-children">
            <div class="admin-card p-5 group">
                <div class="flex items-center justify-between mb-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-glasses text-emerald-600"></i>
                    </div>
                    <span class="text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-full">In
                        Stock</span>
                </div>
                <div class="text-2xl font-bold text-gray-900">248</div>
                <div class="text-xs text-gray-500 mt-0.5">Total Frames</div>
                <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-4/5 bg-emerald-500 rounded-full"></div>
                </div>
            </div>
            <div class="admin-card p-5 group">
                <div class="flex items-center justify-between mb-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-eye text-blue-600"></i>
                    </div>
                    <span class="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full">In Stock</span>
                </div>
                <div class="text-2xl font-bold text-gray-900">156</div>
                <div class="text-xs text-gray-500 mt-0.5">Total Lenses</div>
                <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-3/5 bg-blue-500 rounded-full"></div>
                </div>
            </div>
            <div class="admin-card p-5 group">
                <div class="flex items-center justify-between mb-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bag-shopping text-purple-600"></i>
                    </div>
                    <span class="text-xs text-purple-600 font-medium bg-purple-50 px-2 py-0.5 rounded-full">In Stock</span>
                </div>
                <div class="text-2xl font-bold text-gray-900">89</div>
                <div class="text-xs text-gray-500 mt-0.5">Accessories</div>
                <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-2/5 bg-purple-500 rounded-full"></div>
                </div>
            </div>
            <div class="admin-card p-5 group">
                <div class="flex items-center justify-between mb-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gray-800 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-cubes text-white"></i>
                    </div>
                    <span class="text-xs text-gray-600 font-medium bg-gray-100 px-2 py-0.5 rounded-full">Total</span>
                </div>
                <div class="text-2xl font-bold text-gray-900">493</div>
                <div class="text-xs text-gray-500 mt-0.5">Total Items</div>
                <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-full bg-gradient-to-r from-[#0F3D2A] to-[#f4d03f] rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Stock Level Alerts + Recent Movements -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 stagger-children">
            <!-- Low Stock Alerts -->
            <div class="admin-card overflow-hidden lg:col-span-1">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold font-serif text-gray-900">Low Stock Alerts</h3>
                        <p class="text-[11px] text-gray-500 mt-0.5">Items below threshold</p>
                    </div>
                    <span class="badge badge-danger text-[10px]">3 items</span>
                </div>
                <div class="divide-y divide-gray-50">
                    @php
                        $lowStock = [
                            ['Vienna Crystal', 'Frame', 8, 20, 'danger'],
                            ['Tokyo Blue', 'Lens', 5, 15, 'danger'],
                            ['Paris Rose Gold', 'Accessories', 3, 10, 'danger'],
                        ];
                    @endphp
                    @foreach ($lowStock as $item)
                        <div class="px-5 py-3.5 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item[0] }}</p>
                                    <span class="badge badge-neutral text-[9px] px-1.5 py-0">{{ $item[1] }}</span>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ $item[2] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full bg-red-500"
                                        style="width: {{ ($item[2] / $item[3]) * 100 }}%"></div>
                                </div>
                                <span class="text-[10px] text-gray-400">Min: {{ $item[3] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-5 py-3 bg-red-50/50 border-t border-red-100">
                    <p class="text-[11px] text-red-600 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        These items need restocking soon
                    </p>
                </div>
            </div>

            <!-- Recent Movements Table -->
            <div class="admin-card overflow-hidden lg:col-span-2">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold font-serif text-gray-900">Recent Movements</h3>
                        <p class="text-[11px] text-gray-500 mt-0.5">Latest stock changes</p>
                    </div>
                    <span class="badge badge-neutral text-[10px]">Last 10 entries</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Type</th>
                                <th>Product Name</th>
                                <th>Movement</th>
                                <th>Category</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-medium text-gray-900">001</td>
                                <td>Frame</td>
                                <td class="font-medium text-gray-900">Aurel</td>
                                <td>
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-arrow-up"></i>
                                        IN
                                    </span>
                                </td>
                                <td class="text-gray-500">New Stock</td>
                                <td class="text-gray-400 text-xs">May 20, 2026</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-gray-900">002</td>
                                <td>Lens</td>
                                <td class="font-medium text-gray-900">Transition Lens</td>
                                <td>
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-arrow-up"></i>
                                        IN
                                    </span>
                                </td>
                                <td class="text-gray-500">Refund</td>
                                <td class="text-gray-400 text-xs">May 19, 2026</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-gray-900">003</td>
                                <td>Accessories</td>
                                <td class="font-medium text-gray-900">Luxe Case</td>
                                <td>
                                    <span class="badge badge-danger">
                                        <i class="fa-solid fa-arrow-down"></i>
                                        OUT
                                    </span>
                                </td>
                                <td class="text-gray-500">Sold</td>
                                <td class="text-gray-400 text-xs">May 18, 2026</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-gray-900">004</td>
                                <td>Lens</td>
                                <td class="font-medium text-gray-900">Blue Lens</td>
                                <td>
                                    <span class="badge badge-danger">
                                        <i class="fa-solid fa-arrow-down"></i>
                                        OUT
                                    </span>
                                </td>
                                <td class="text-gray-500">Damaged</td>
                                <td class="text-gray-400 text-xs">May 17, 2026</td>
                            </tr>
                            @for ($i = 5; $i <= 10; $i++)
                                <tr>
                                    <td class="font-medium text-gray-900">00{{ $i }}</td>
                                    <td>{{ $i % 2 === 0 ? 'Frame' : 'Lens' }}</td>
                                    <td class="font-medium text-gray-900">Product {{ chr(64 + $i) }}</td>
                                    <td>
                                        <span class="badge {{ $i % 3 === 0 ? 'badge-danger' : 'badge-success' }}">
                                            <i class="fa-solid {{ $i % 3 === 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                                            {{ $i % 3 === 0 ? 'OUT' : 'IN' }}
                                        </span>
                                    </td>
                                    <td class="text-gray-500">{{ $i % 2 === 0 ? 'Sold' : 'New Stock' }}</td>
                                    <td class="text-gray-400 text-xs">May {{ 15 + $i }}, 2026</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <!-- Table Footer -->
                <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <span>Showing 10 recent movements</span>
                    <button
                        class="text-[#0F3D2A] font-medium hover:text-[#f4d03f] transition-colors flex items-center gap-1">
                        View Full Report
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
