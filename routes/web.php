<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AdminController;
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
        $product = Product::active()->find($productId);
    }

    $lenses = Product::active()->where('type', 'lens')->get();
    $accessories = Product::active()->where('type', 'accessory')->get();

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

    // ── Guest routes (login) ────────────────────────────────────────
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');

    // ── Authenticated routes ────────────────────────────────────────
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/orders', function () {
            return view('admin.orders');
        })->name('orders');

        Route::get('/products', [AdminProductController::class, 'index'])->name('products');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');

        Route::get('/productmanagement', function () {
            return view('admin.productmanagement');
        })->name('productmanagement');

        Route::get('/inventory', function () {
            return view('admin.inventory');
        })->name('inventory');
    });
});
