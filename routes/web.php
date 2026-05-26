<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dummy Product Data
|--------------------------------------------------------------------------
|
| All products available across the store.
*/

$allProducts = [
    // Men's frames (0-7)
    [
        'id' => 1,
        'name' => 'Kairo',
        'description' => 'Matte Black • Classic Design',
        'price' => 199,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 256,
        'badge' => 'Bestseller',
        'badgeColor' => '#1a3c2e',
        'category' => 'men',
    ],
    [
        'id' => 2,
        'name' => 'Atlas',
        'description' => 'Tortoiseshell • Bold Acetate',
        'price' => 259,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 67,
        'badge' => null,
        'badgeColor' => '#1a3c2e',
        'category' => 'men',
    ],
    [
        'id' => 3,
        'name' => 'Noir Gold',
        'description' => 'Premium Gold Frame • Unisex',
        'price' => 249,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 124,
        'badge' => 'New',
        'badgeColor' => '#f59e0b',
        'category' => 'men',
    ],
    [
        'id' => 4,
        'name' => 'Aviator',
        'description' => 'Silver Metal • Classic Aviator',
        'price' => 279,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 189,
        'badge' => 'Bestseller',
        'badgeColor' => '#1a3c2e',
        'category' => 'men',
    ],
    [
        'id' => 5,
        'name' => 'Cullen',
        'description' => 'Dark Blue • Sophisticated',
        'price' => 239,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 92,
        'badge' => null,
        'badgeColor' => '#1a3c2e',
        'category' => 'men',
    ],
    [
        'id' => 6,
        'name' => 'Rex',
        'description' => 'Gunmetal • Modern Rectangular',
        'price' => 179,
        'oldPrice' => 219,
        'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 156,
        'badge' => 'Sale',
        'badgeColor' => '#f59e0b',
        'category' => 'men',
    ],
    [
        'id' => 7,
        'name' => 'Orion',
        'description' => 'Havana Brown • Round',
        'price' => 229,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 78,
        'badge' => null,
        'badgeColor' => '#1a3c2e',
        'category' => 'men',
    ],
    [
        'id' => 8,
        'name' => 'Volt',
        'description' => 'Carbon Fiber • Sport',
        'price' => 299,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 210,
        'badge' => 'Bestseller',
        'badgeColor' => '#1a3c2e',
        'category' => 'men',
    ],
    // Women's frames (8-15)
    [
        'id' => 9,
        'name' => 'Luna',
        'description' => 'Rose Gold • Thin Metal',
        'price' => 229,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 198,
        'badge' => 'Bestseller',
        'badgeColor' => '#1a3c2e',
        'category' => 'women',
    ],
    [
        'id' => 10,
        'name' => 'Aurel',
        'description' => 'Burgundy Acetate • Statement',
        'price' => 279,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 89,
        'badge' => 'New',
        'badgeColor' => '#f59e0b',
        'category' => 'women',
    ],
    [
        'id' => 11,
        'name' => 'Stella',
        'description' => 'Cat-eye • Black with Gold',
        'price' => 259,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 167,
        'badge' => 'Bestseller',
        'badgeColor' => '#1a3c2e',
        'category' => 'women',
    ],
    [
        'id' => 12,
        'name' => 'Iris',
        'description' => 'Light Pink • Translucent',
        'price' => 219,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 143,
        'badge' => null,
        'badgeColor' => '#1a3c2e',
        'category' => 'women',
    ],
    [
        'id' => 13,
        'name' => 'Nova',
        'description' => 'Crystal Clear • Modern',
        'price' => 179,
        'oldPrice' => 219,
        'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 43,
        'badge' => 'Sale',
        'badgeColor' => '#f59e0b',
        'category' => 'women',
    ],
    [
        'id' => 14,
        'name' => 'Celeste',
        'description' => 'Lavender • Round Frame',
        'price' => 239,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 55,
        'badge' => 'New',
        'badgeColor' => '#f59e0b',
        'category' => 'women',
    ],
    [
        'id' => 15,
        'name' => 'Belle',
        'description' => 'Tortoiseshell • Cat-eye',
        'price' => 249,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 112,
        'badge' => null,
        'badgeColor' => '#1a3c2e',
        'category' => 'women',
    ],
    [
        'id' => 16,
        'name' => 'Dune',
        'description' => 'Beige Cream • Oval',
        'price' => 269,
        'oldPrice' => null,
        'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&q=80&auto=format&fit=crop',
        'rating' => 5,
        'reviews' => 201,
        'badge' => 'Bestseller',
        'badgeColor' => '#1a3c2e',
        'category' => 'women',
    ],
];

$bestSellers = array_filter($allProducts, fn ($p) => $p['badge'] === 'Bestseller');
$menProducts = array_filter($allProducts, fn ($p) => $p['category'] === 'men');
$womenProducts = array_filter($allProducts, fn ($p) => $p['category'] === 'women');

// ─── Public Routes ──────────────────────────────────────────────────

Route::get('/about', function () {
    return view('about');
});

Route::get('/', function () use ($bestSellers) {
    return view('index', ['bestSellers' => $bestSellers]);
});

Route::get('/frames/men', function () use ($menProducts) {
    return view('frames.men', ['products' => $menProducts]);
});

Route::get('/frames/women', function () use ($womenProducts) {
    return view('frames.women', ['products' => $womenProducts]);
});

Route::get('/framedetail', function () {
    return view('framedetail');
});

Route::get('/checkout', function () use ($allProducts) {
    $productId = request()->query('product');
    $product = null;
    if ($productId && isset($allProducts[(int) $productId - 1])) {
        $product = $allProducts[(int) $productId - 1];
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
