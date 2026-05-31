<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashboardDataController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────────

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/about', [ProductController::class, 'about'])->name('about');

Route::get('/frames/men', [ProductController::class, 'men'])->name('frames.men');
Route::get('/frames/women', [ProductController::class, 'women'])->name('frames.women');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

Route::prefix('order')->name('order.')->group(function () {
    Route::get('/', [CheckoutController::class, 'placeOrder'])->name('place');
    Route::post('/send-otp', [CheckoutController::class, 'sendOtp'])->name('sendOtp');
    Route::post('/resend-otp', [CheckoutController::class, 'resendOtp'])->name('resendOtp');
    Route::post('/verify-otp', [CheckoutController::class, 'verifyOtp'])->name('verifyOtp');
    Route::post('/store', [CheckoutController::class, 'storeOrder'])->name('store');
});

// ─── Admin Routes (prefix: /admin) ─────────────────────────────────

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/data', DashboardDataController::class)->name('dashboard.data');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::get('/products', [AdminProductController::class, 'index'])->name('products');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::get('/products/{product}/movements', [AdminProductController::class, 'movements'])->name('products.movements');
        Route::post('/products/{product}/movements', [AdminProductController::class, 'storeMovement'])->name('products.movements.store');

        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    });
});
