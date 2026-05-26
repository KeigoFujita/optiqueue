<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index()
    {
        $products = Product::active()->get();
        $bestSellers = Product::active()->where('badge', 'Bestseller')->get();

        // ── Category counts for "Shop by Category" section ──────
        $menCount = Product::active()->where('category', 'men')->where('type', 'frame')->count();
        $womenCount = Product::active()->where('category', 'women')->where('type', 'frame')->count();
        $lensCount = Product::active()->where('type', 'lens')->count();
        $accessoriesCount = Product::active()->where('type', 'accessory')->count();

        return view('index', [
            'products' => $products,
            'bestSellers' => $bestSellers,
            'menCount' => $menCount,
            'womenCount' => $womenCount,
            'lensCount' => $lensCount,
            'accessoriesCount' => $accessoriesCount,
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
        return view('checkout', ['product' => $product]);
    }
}
