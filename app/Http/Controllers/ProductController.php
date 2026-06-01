<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function about()
    {
        return view('about');
    }

    /**
     * Display a listing of all products.
     */
    public function index()
    {
        $bestSellers = Product::active()->where('badge', 'Bestseller')->get();

        $counts = Product::active()->selectRaw("
            SUM(CASE WHEN category = 'men'   AND type = 'frame'     THEN 1 ELSE 0 END) as men_count,
            SUM(CASE WHEN category = 'women' AND type = 'frame'     THEN 1 ELSE 0 END) as women_count,
            SUM(CASE WHEN type = 'lens'                             THEN 1 ELSE 0 END) as lens_count,
            SUM(CASE WHEN type = 'accessory'                        THEN 1 ELSE 0 END) as accessories_count
        ")->first();

        return view('index', [
            'bestSellers' => $bestSellers,
            'menCount' => (int) $counts->men_count,
            'womenCount' => (int) $counts->women_count,
            'lensCount' => (int) $counts->lens_count,
            'accessoriesCount' => (int) $counts->accessories_count,
        ]);
    }

    /**
     * Display men's frames with optional filter and sort.
     */
    public function men()
    {
        $query = Product::active()->where('category', 'men');

        // ── Filter ──────────────────────────────────────────────
        $filter = request()->query('filter', 'all');
        if ($filter !== 'all') {
            if ($filter === 'Sale') {
                $query->where(function ($q) {
                    $q->where('badge', 'Sale')
                        ->orWhereNotNull('old_price');
                });
            } else {
                $query->where('badge', $filter);
            }
        }

        // ── Sort ────────────────────────────────────────────────
        $sort = request()->query('sort', 'low');
        if ($sort === 'high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('price', 'asc');
        }

        $products = $query->get();

        return view('frames.men', [
            'products' => $products,
            'currentFilter' => $filter,
            'currentSort' => $sort,
        ]);
    }

    /**
     * Display women's frames with optional filter and sort.
     */
    public function women()
    {
        $query = Product::active()->where('category', 'women');

        // ── Filter ──────────────────────────────────────────────
        $filter = request()->query('filter', 'all');
        if ($filter !== 'all') {
            if ($filter === 'Sale') {
                $query->where(function ($q) {
                    $q->where('badge', 'Sale')
                        ->orWhereNotNull('old_price');
                });
            } else {
                $query->where('badge', $filter);
            }
        }

        // ── Sort ────────────────────────────────────────────────
        $sort = request()->query('sort', 'low');
        if ($sort === 'high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('price', 'asc');
        }

        $products = $query->get();

        return view('frames.women', [
            'products' => $products,
            'currentFilter' => $filter,
            'currentSort' => $sort,
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('checkout', ['frame' => $product]);
    }
}
