<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a paginated, filterable, searchable list of orders.
     */
    public function index(Request $request): View
    {
        $query = Order::with('customer')->latest();

        // ── Status filter ─────────────────────────────────────────────
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // ── Search ────────────────────────────────────────────────────
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_no', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        // ── Stats for the overview cards ──────────────────────────────
        $totalOrders = Order::count();
        $pendingCount = Order::where('status', 'pending')->count();
        $processingCount = Order::where('status', 'processing')->count();
        $readyCount = Order::where('status', 'ready')->count();
        $pickedUpCount = Order::where('status', 'picked-up')->count();

        $statusLabels = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'ready' => 'Ready',
            'picked-up' => 'Picked Up',
            'cancelled' => 'Cancelled',
        ];

        return view('admin.orders', compact(
            'orders',
            'totalOrders',
            'pendingCount',
            'processingCount',
            'readyCount',
            'pickedUpCount',
            'statusLabels'
        ));
    }

    /**
     * Return JSON with full order details for the modal.
     */
    public function show(int $id): JsonResponse
    {
        $order = Order::with([
            'customer',
            'orderDetails.product',
        ])->findOrFail($id);

        $itemsHtml = view('admin.partials.order-items', ['order' => $order])->render();

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_no' => $order->order_no,
                'status' => $order->status,
                'total_amount' => number_format($order->total_amount, 2),
                'created_at' => $order->created_at->format('M d, Y h:i A'),
                'customer' => [
                    'name' => $order->customer->name ?? '—',
                    'email' => $order->customer->email,
                    'phone_number' => $order->customer->phone_number ?? '—',
                ],
                'items_html' => $itemsHtml,
            ],
        ]);
    }

    /**
     * Update the order status and send an email notification.
     */
    public function updateStatus(UpdateOrderStatusRequest $request, int $id): JsonResponse
    {
        $order = Order::with('customer')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->validated('status');

        // Prevent editing if already in a terminal state
        if (in_array($oldStatus, ['picked-up', 'cancelled'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'This order is already '.str_replace('-', ' ', $oldStatus).' and cannot be changed.',
            ], 422);
        }

        $order->status = $newStatus;
        $order->save();

        // ── Send email notification ───────────────────────────────────
        try {
            $order->load('orderDetails.product');
            Mail::to($order->customer->email)->send(new OrderStatusMail($order, $oldStatus));
        } catch (\Exception $e) {
            Log::error('Failed to send status update email: '.$e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Order status updated to '.str_replace('-', ' ', ucwords($newStatus, '-')).'.',
            'order' => [
                'id' => $order->id,
                'status' => $order->status,
            ],
        ]);
    }
}
