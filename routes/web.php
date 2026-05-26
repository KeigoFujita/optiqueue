<?php

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

    return view('checkout', ['product' => $product]);
});

Route::get('/order', function () {
    $params = [
        'frame' => request()->query('frame', ''),
        'lens' => request()->query('lens', 'Standard'),
        'lensPrice' => (int) request()->query('lensPrice', 0),
        'accessory' => request()->query('accessory', 'Default Case'),
        'accessoryPrice' => (int) request()->query('accessoryPrice', 0),
        'total' => (int) request()->query('total', 0),
    ];

    return view('place-order', $params);
});

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
