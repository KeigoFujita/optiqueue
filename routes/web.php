<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────────

Route::get('/about', function () {
    return view('about');
});

Route::get('/', [ProductController::class, 'index']);

Route::get('/frames/men', [ProductController::class, 'men']);

Route::get('/frames/women', [ProductController::class, 'women']);

Route::get('/checkout', function () {
    $productId = request()->query('product');
    $product = null;
    if ($productId) {
        $product = Product::find($productId);
    }

    $lenses = Product::where('type', 'lens')->get();
    $accessories = Product::where('type', 'accessory')->get();

    return view('checkout', [
        'product' => $product,
        'lenses' => $lenses,
        'accessories' => $accessories,
    ]);
});

Route::get('/order', [CheckoutController::class, 'placeOrder'])->name('order.place');

// ─── AJAX / Order Routes ────────────────────────────────────────────
Route::post('/order/send-otp', [CheckoutController::class, 'sendOtp'])->name('order.sendOtp');
Route::post('/order/resend-otp', [CheckoutController::class, 'resendOtp'])->name('order.resendOtp');
Route::post('/order/verify-otp', [CheckoutController::class, 'verifyOtp'])->name('order.verifyOtp');
Route::post('/order/store', [CheckoutController::class, 'storeOrder'])->name('order.store');

Route::get('/framedetail', function () {
    return view('framedetail');
});

// ─── Admin Routes (prefix: /admin) ─────────────────────────────────

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');

    Route::post('/login', function () {
        // TODO: Add admin authentication logic
        return redirect()->route('admin.dashboard');
    })->name('login.submit');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/orders', function () {
        return view('admin.orders');
    })->name('orders');

    Route::get('/products', function () {
        return view('admin.products');
    })->name('products');

    Route::get('/productmanagement', function () {
        return view('admin.productmanagement');
    })->name('productmanagement');

    Route::get('/inventory', function () {
        return view('admin.inventory');
    })->name('inventory');
});
