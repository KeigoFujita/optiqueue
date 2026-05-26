@php
    $frame = $order->orderDetails->filter(fn($d) => $d->product && $d->product->type === 'frame')->first();
    $lens = $order->orderDetails->filter(fn($d) => $d->product && $d->product->type === 'lens')->first();
    $accessories = $order->orderDetails->filter(fn($d) => $d->product && $d->product->type === 'accessory');
@endphp

<!-- Frame -->
@if ($frame)
    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 text-xs">
                <i class="fa-solid fa-glasses"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $frame->product->name }}</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Frame</p>
            </div>
        </div>
        <p class="text-sm font-semibold text-gray-900">${{ number_format($frame->product->price, 2) }}</p>
    </div>
@endif

<!-- Lens -->
@if ($lens)
    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 text-xs">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $lens->product->name }}</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Lens</p>
            </div>
        </div>
        <p class="text-sm font-semibold text-gray-900">${{ number_format($lens->product->price, 2) }}</p>
    </div>
@endif

<!-- Accessories -->
@foreach ($accessories as $acc)
    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-xs">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $acc->product->name }}</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Accessory</p>
            </div>
        </div>
        <p class="text-sm font-semibold text-gray-900">${{ number_format($acc->product->price, 2) }}</p>
    </div>
@endforeach

@if (!$frame && !$lens && $accessories->isEmpty())
    <p class="text-sm text-gray-400 text-center py-4">No items found for this order.</p>
@endif
