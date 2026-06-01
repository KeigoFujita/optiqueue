<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Mail\OrderConfirmationMail;
use App\Mail\OtpMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $frameId = $request->query('frame_id');

        if (! $frameId || ! $frame = Product::active()->where('type', 'frame')->find($frameId)) {
            return redirect()->route('home');
        }

        $lenses = Product::active()->where('type', 'lens')->get();
        $accessories = Product::active()->where('type', 'accessory')->get();

        return view('checkout', [
            'frame' => $frame,
            'lenses' => $lenses,
            'accessories' => $accessories,
        ]);
    }

    /**
     * Display the place-order page with product details calculated.
     *
     * Expects query parameters: frame_id, lens_id, accessory_id
     */
    public function placeOrder(Request $request)
    {
        $frameId = $request->query('frame_id');
        $lensId = $request->query('lens_id');
        $accessoryId = $request->query('accessory_id');

        $frame = $frameId ? Product::find($frameId) : null;
        $lens = $lensId ? Product::find($lensId) : null;
        $accessory = $accessoryId ? Product::find($accessoryId) : null;

        $frameValid = $frame && $frame->type === 'frame';
        $lensValid = $lens && $lens->type === 'lens';
        $accessoryValid = $accessory && $accessory->type === 'accessory';

        if (! $frameValid) {
            return redirect()->route('home');
        }

        if (! $lensValid || ! $accessoryValid) {
            return redirect()->route('checkout', ['frame_id' => $frameId]);
        }

        return view('place-order', [
            'frame' => $frame,
            'lens' => $lens,
            'accessory' => $accessory,
            'framePrice' => (int) $frame->price,
            'lensPrice' => (int) $lens->price,
            'accessoryPrice' => (int) $accessory->price,
            'total' => (int) $frame->price + (int) $lens->price + (int) $accessory->price,
            'frameId' => $frameId,
            'lensId' => $lensId,
            'accessoryId' => $accessoryId,
        ]);
    }

    /**
     * Send OTP to the given email.
     * Creates a new customer or updates existing one with a fresh OTP.
     */
    public function sendOtp(SendOtpRequest $request)
    {
        $email = $request->validated('email');
        $otp = Customer::generateOtp();

        // Find or create customer by email
        $customer = Customer::firstOrNew(['email' => $email]);
        $customer->otp = $otp;
        $customer->otp_expires_at = now()->addMinutes(5);
        $customer->save();

        // Send OTP via email using Mailtrap/SMTP
        try {
            Mail::to($email)->send(new OtpMail($otp, $customer->name ?? 'Valued Customer'));
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: '.$e->getMessage());
        }

        Log::info("OTP for {$email}: {$otp}");

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully.',
        ]);
    }

    /**
     * Resend a new OTP to the customer's email.
     */
    public function resendOtp(SendOtpRequest $request)
    {
        $email = $request->validated('email');
        $customer = Customer::where('email', $email)->first();

        if (! $customer) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found. Please verify your email first.',
            ], 404);
        }

        $otp = Customer::generateOtp();
        $customer->otp = $otp;
        $customer->otp_expires_at = now()->addMinutes(5);
        $customer->save();

        // Send OTP via email using Mailtrap/SMTP
        try {
            Mail::to($email)->send(new OtpMail($otp, $customer->name ?? 'Valued Customer'));
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP email: '.$e->getMessage());
        }

        Log::info("OTP resent for {$email}: {$otp}");

        return response()->json([
            'success' => true,
            'message' => 'New OTP sent successfully.',
        ]);
    }

    /**
     * Verify the OTP entered by the customer.
     * If valid, update verified_at timestamp.
     */
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $email = $request->validated('email');
        $otp = $request->validated('otp');

        $customer = Customer::where('email', $email)->first();

        if (! $customer) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found.',
            ], 404);
        }

        if (! $customer->isValidOtp($otp)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.',
            ], 422);
        }

        // Mark email as verified
        $customer->verified_at = now();
        $customer->otp = null;        // clear OTP after successful verification
        $customer->otp_expires_at = null;
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',
            'customer_id' => $customer->id,
        ]);
    }

    public function storeOrder(StoreOrderRequest $request)
    {
        $email = $request->validated('email');
        $name = $request->validated('name');
        $contact = $request->validated('contact');
        $frameId = $request->validated('frame_id');
        $lensId = $request->validated('lens_id');
        $accessoryId = $request->validated('accessory_id');

        // Begin database transaction
        try {
            DB::beginTransaction();

            // 1. Find or create customer and update their info
            $customer = Customer::where('email', $email)->firstOrFail();

            // Ensure customer is verified
            if (! $customer->verified_at) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Email not verified. Please verify your email first.',
                ], 422);
            }

            $customer->name = $name;
            $customer->phone_number = $contact;
            $customer->save();

            // 2. Calculate total amount
            $framePrice = $frameId ? (int) Product::find($frameId)->price : 0;
            $lensPrice = $lensId ? (int) Product::find($lensId)->price : 0;
            $accessoryPrice = $accessoryId ? (int) Product::find($accessoryId)->price : 0;
            $totalAmount = $framePrice + $lensPrice + $accessoryPrice;

            // 3. Create order
            $orderNo = 'ORD-'.strtoupper(uniqid());
            $order = Order::create([
                'order_no' => $orderNo,
                'customer_id' => $customer->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // 4. Create order details for each product
            $products = [];

            if ($frameId) {
                $products[] = ['product_id' => $frameId, 'quantity' => 1];
            }
            if ($lensId) {
                $products[] = ['product_id' => $lensId, 'quantity' => 1];
            }
            if ($accessoryId) {
                $products[] = ['product_id' => $accessoryId, 'quantity' => 1];
            }

            foreach ($products as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);

                // ── Deduct stock and record product movement ──────────
                $product = Product::findOrFail($item['product_id']);

                $updated = Product::where('id', $item['product_id'])
                    ->where('stocks', '>=', $item['quantity'])
                    ->decrement('stocks', $item['quantity']);

                if ($updated === 0) {
                    throw new \RuntimeException(
                        "Insufficient stock for product '{$product->name}': only {$product->stocks} left, requested {$item['quantity']}."
                    );
                }

                ProductMovement::create([
                    'product_id' => $product->id,
                    'movement_type' => 'out',
                    'movement_category' => 'sale',
                    'quantity' => $item['quantity'],
                    'movement_date' => now()->toDateString(),
                    'reference_id' => $order->order_no,
                ]);
            }

            DB::commit();

            // Send order confirmation email
            try {
                $order->load('customer', 'orderDetails.product');
                Mail::to($order->customer->email)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                Log::error('Failed to send order confirmation email: '.$e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_no' => $orderNo,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Order placement failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
            ], 500);
        }
    }
}
