<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a paginated/filterable list of products.
     */
    public function index(Request $request): View
    {
        $query = Product::query();

        // ── Category / Status filter ────────────────────────────
        $filter = $request->query('filter', 'all');
        if ($filter === 'archived') {
            // Show only archived products
            $query->where('status', 'archived');
        } else {
            // Default & category filters: show only active products
            $query->where('status', 'active');

            if ($filter !== 'all') {
                $query->where('type', $filter);
            }
        }

        // ── Search ─────────────────────────────────────────────
        $search = $request->query('search');
        if ($search) {
            $searchTerm = '%'.$search.'%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            });
        }

        // ── Order by newest first ──────────────────────────────
        $query->orderBy('created_at', 'desc')->orderBy('id', 'desc');

        $products = $query->get();

        return view('admin.products', [
            'products' => $products,
            'currentFilter' => $filter,
            'currentSearch' => $search ?? '',
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        // ── Determine image subdirectory based on type & category ─
        // frames go into frames/{men|women}, lens/accessory use their type folder
        $type = $request->validated('type');
        $category = $request->validated('category');

        if ($type === 'frame') {
            $subDir = 'frames/'.$category; // frames/men or frames/women
        } else {
            $subDir = $type.'s'; // lenses or accessories
        }

        // ── Handle image upload ─────────────────────────────────
        $imagePath = '';
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->validated('name')).'.'.$extension;
            $imagePath = $request->file('image')->storeAs($subDir, $filename, 'public');
        }

        // ── Create product ──────────────────────────────────────
        $product = Product::create([
            'name' => $request->validated('name'),
            'description' => $request->validated('description'),
            'category' => $category,
            'type' => $type,
            'price' => $request->validated('price'),
            'old_price' => $request->validated('old_price'),
            'image_path' => $imagePath,
            'icon' => $request->validated('icon'),
            'badge' => $request->validated('badge'),
            'badge_color' => $request->validated('badge_color'),
            'stocks' => $request->validated('stocks', 0),
            'status' => $request->validated('status'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        return view('admin.productmanagement', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        // ── Determine image subdirectory based on type & category ─
        $type = $request->validated('type');
        $category = $request->validated('category');

        if ($type === 'frame') {
            $subDir = 'frames/'.$category;
        } else {
            $subDir = $type.'s';
        }

        // ── Handle image upload ─────────────────────────────────
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->validated('name')).'.'.$extension;
            $imagePath = $request->file('image')->storeAs($subDir, $filename, 'public');
        } else {
            $imagePath = $product->image_path;
        }

        // ── Update product ──────────────────────────────────────
        $product->update([
            'name' => $request->validated('name'),
            'description' => $request->validated('description'),
            'category' => $category,
            'type' => $type,
            'price' => $request->validated('price'),
            'old_price' => $request->validated('old_price'),
            'image_path' => $imagePath,
            'icon' => $request->validated('icon'),
            'badge' => $request->validated('badge'),
            'badge_color' => $request->validated('badge_color'),
            'stocks' => $request->validated('stocks', 0),
            'status' => $request->validated('status'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!',
            'product' => $product->fresh(),
        ]);
    }

    /**
     * Display the product movements page.
     */
    public function movements(Product $product): View
    {
        $movements = $product->movements()->orderBy('movement_date', 'desc')->get();
        $totalIn = $movements->where('movement_type', 'in')->sum('quantity');
        $totalOut = $movements->whereIn('movement_type', ['out', 'adjustment'])->sum('quantity');

        return view('admin.productmovements', [
            'product' => $product,
            'movements' => $movements,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
        ]);
    }

    /**
     * Store a new product movement.
     */
    public function storeMovement(StoreMovementRequest $request, Product $product): JsonResponse
    {
        $movement = $product->movements()->create($request->validated());

        // Update product stocks based on movement type
        if ($request->validated('movement_type') === 'in') {
            $product->increment('stocks', $request->validated('quantity'));
        } elseif ($request->validated('movement_type') === 'out') {
            $product->decrement('stocks', $request->validated('quantity'));
        }
        // adjustments don't auto-update stock (manual correction)

        return response()->json([
            'success' => true,
            'message' => 'Movement recorded successfully!',
            'movement' => $movement,
            'stock' => $product->fresh()?->stocks,
        ]);
    }
}
