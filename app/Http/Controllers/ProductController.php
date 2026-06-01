<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\View\View;

class ProductController extends Controller
{
    public function about(): View
    {
        return view('about');
    }

    /**
     * Display a listing of all products.
     */
    public function index(): View
    {
        $bestSellers = Product::active()->where('badge', 'Bestseller')->get();

        $counts = Product::active()->selectRaw("
            SUM(CASE WHEN category = 'men'   AND type = 'frame'     THEN 1 ELSE 0 END) as men_count,
            SUM(CASE WHEN category = 'women' AND type = 'frame'     THEN 1 ELSE 0 END) as women_count,
            SUM(CASE WHEN type = 'lens'                             THEN 1 ELSE 0 END) as lens_count,
            SUM(CASE WHEN type = 'accessory'                        THEN 1 ELSE 0 END) as accessories_count
        ")->first();

        $countsArray = $counts !== null ? $counts->toArray() : [];

        return view('index', [
            'bestSellers' => $bestSellers,
            'menCount' => (int) ($countsArray['men_count'] ?? 0),
            'womenCount' => (int) ($countsArray['women_count'] ?? 0),
            'lensCount' => (int) ($countsArray['lens_count'] ?? 0),
            'accessoriesCount' => (int) ($countsArray['accessories_count'] ?? 0),
        ]);
    }

    /**
     * Display men's frames with optional filter and sort.
     */
    public function men(): View
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
    public function women(): View
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
    public function show(Product $product): View
    {
        return view('checkout', ['frame' => $product]);
    }
}
