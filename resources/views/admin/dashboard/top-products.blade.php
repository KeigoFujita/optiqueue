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
    <div class="divide-y divide-gray-50" id="top-products-list">
        @forelse ($topProducts as $product)
            @php
                $maxQty = $topProducts->max('total_qty') ?: 1;
                $pct = round(($product->total_qty / $maxQty) * 100);
                $revenue = (float) ($product->total_revenue ?? 0);
            @endphp
            <div class="px-6 py-3.5 hover:bg-gray-50/50 transition-colors">
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="text-xs font-bold text-gray-400 w-4">{{ $loop->iteration }}</span>
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $product->product?->name ?? 'Unknown' }}</p>
                        <span class="badge badge-neutral text-[9px] px-1.5 py-0">{{ ucfirst($product->product?->type ?? '') }}</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 shrink-0">${{ number_format($revenue, 2) }}</span>
                </div>
                <div class="flex items-center gap-3 ml-6">
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-[#0F3D2A] to-[#f4d03f]"
                            style="width: {{ $pct }}%">
                        </div>
                    </div>
                    <span class="text-[11px] text-gray-500 w-16 text-right">{{ number_format($product->total_qty) }} units</span>
                </div>
            </div>
        @empty
            <div class="px-6 py-8 text-center text-sm text-gray-400">
                No products sold this month
            </div>
        @endforelse
    </div>
</div>
