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
    <div class="divide-y divide-gray-50" id="recent-orders-list">
        @forelse ($recentOrders as $order)
            <div class="px-6 py-3.5 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                <div class="flex items-center gap-3 min-w-0">
                    <div
                        class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-semibold text-gray-500 shrink-0">
                        <i class="fa-solid fa-receipt text-gray-400 text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ $order->customer?->name ?? 'Unknown' }}
                        </p>
                        <p class="text-xs text-gray-400 font-mono">{{ $order->order_no }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 shrink-0">
                    <span class="text-sm font-semibold text-gray-800">
                        ₱{{ number_format($order->total_amount, 2) }}
                    </span>
                    @php
                        $statusBadge = match ($order->status) {
                            'pending' => 'info',
                            'processing' => 'info',
                            'ready' => 'success',
                            'picked-up' => 'neutral',
                            'cancelled' => 'danger',
                            default => 'neutral',
                        };
                        $statusLabel = match ($order->status) {
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'ready' => 'Ready',
                            'picked-up' => 'Picked Up',
                            'cancelled' => 'Cancelled',
                            default => $order->status,
                        };
                    @endphp
                    <span class="badge badge-{{ $statusBadge }} text-[10px]">{{ $statusLabel }}</span>
                </div>
            </div>
        @empty
            <div class="px-6 py-8 text-center text-sm text-gray-400">
                No orders yet
            </div>
        @endforelse
    </div>
</div>
