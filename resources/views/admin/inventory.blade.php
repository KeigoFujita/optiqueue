@extends('layouts.admin')

@section('title', 'Inventory - Products Movement | Optiqueue')

@section('page-header')
    <div>
        <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">Inventory</h2>
        <p class="text-sm text-gray-500 mt-0.5">Track products movement and stock levels</p>
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
                <div class="text-2xl font-bold text-gray-900">{{ $totalFrames }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Total Frames</div>
                <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full"
                        style="width: {{ $totalItems > 0 ? ($totalFrames / $totalItems) * 100 : 0 }}%"></div>
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
                <div class="text-2xl font-bold text-gray-900">{{ $totalLenses }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Total Lenses</div>
                <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full"
                        style="width: {{ $totalItems > 0 ? ($totalLenses / $totalItems) * 100 : 0 }}%"></div>
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
                <div class="text-2xl font-bold text-gray-900">{{ $totalAccessories }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Accessories</div>
                <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-500 rounded-full"
                        style="width: {{ $totalItems > 0 ? ($totalAccessories / $totalItems) * 100 : 0 }}%"></div>
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
                <div class="text-2xl font-bold text-gray-900">{{ $totalItems }}</div>
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
                    <span class="badge badge-danger text-[10px]">{{ $lowStockProducts->count() }} items</span>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse ($lowStockProducts as $item)
                        <div class="px-5 py-3.5 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item->name }}</p>
                                    <span class="badge badge-neutral text-[9px] px-1.5 py-0">{{ ucfirst($item->type) }}</span>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ $item->stocks }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full bg-red-500"
                                        style="width: {{ min(($item->stocks / 20) * 100, 100) }}%"></div>
                                </div>
                                <span class="text-[10px] text-gray-400">Min: 20</span>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-emerald-50 flex items-center justify-center">
                                <i class="fa-solid fa-check text-emerald-500"></i>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">All items are well-stocked</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">No products below the minimum threshold</p>
                        </div>
                    @endforelse
                </div>
                @if ($lowStockProducts->count() > 0)
                    <div class="px-5 py-3 bg-red-50/50 border-t border-red-100">
                        <p class="text-[11px] text-red-600 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            These items need restocking soon
                        </p>
                    </div>
                @endif
            </div>

            <!-- Recent Movements Table -->
            <div class="admin-card overflow-hidden lg:col-span-2">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold font-serif text-gray-900">Recent Movements</h3>
                        <p class="text-[11px] text-gray-500 mt-0.5">Latest stock changes</p>
                    </div>
                    <span class="badge badge-neutral text-[10px]">Last {{ $movements->count() }} entries</span>
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
                            @forelse ($movements as $movement)
                                @php
                                    $isIn = $movement->movement_type === 'in';
                                    $isAdjustment = $movement->movement_type === 'adjustment';
                                    $badgeClass = $isIn ? 'badge-success' : ($isAdjustment ? 'badge-warning' : 'badge-danger');
                                    $iconClass = $isIn ? 'fa-arrow-up' : ($isAdjustment ? 'fa-adjust' : 'fa-arrow-down');
                                    $label = $isIn ? 'IN' : ($isAdjustment ? 'ADJ' : 'OUT');
                                @endphp
                                <tr>
                                    <td class="font-medium text-gray-900">{{ str_pad((string) $movement->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $movement->product ? ucfirst($movement->product->type) : 'Unknown' }}</td>
                                    <td class="font-medium text-gray-900">{{ $movement->product ? $movement->product->name : 'Deleted Product' }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">
                                            <i class="fa-solid {{ $iconClass }}"></i>
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="text-gray-500">{{ str_replace('_', ' ', ucfirst($movement->movement_category)) }}</td>
                                    <td class="text-gray-400 text-xs">{{ $movement->movement_date ? $movement->movement_date->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <i class="fa-solid fa-box-open text-2xl text-gray-300"></i>
                                            <span>No movements found</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Table Footer -->
                <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <span>Showing {{ $movements->count() }} recent movements</span>
                    <a href="{{ route('admin.products') }}"
                        class="text-[#0F3D2A] font-medium hover:text-[#f4d03f] transition-colors flex items-center gap-1">
                        Manage Products
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
