<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        // ── Category filter ────────────────────────────────────
        $filter = $request->query('filter', 'all');
        if ($filter !== 'all') {
            $query->where('type', $filter);
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
        $query->orderBy('created_at', 'desc');

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
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category' => 'required|string|in:men,women,lenses,accessories',
            'type' => 'required|string|in:frame,lens,accessory',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'icon' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:255',
            'badge_color' => 'nullable|string|max:20',
            'stocks' => 'nullable|integer|min:0',
            'status' => 'required|in:active,archived',
        ]);

        // ── Determine image subdirectory based on type & category ─
        // frames go into frames/{men|women}, lens/accessory use their type folder
        if ($validated['type'] === 'frame') {
            $subDir = 'frames/'.$validated['category']; // frames/men or frames/women
        } else {
            $subDir = $validated['type'].'s'; // lenses or accessories
        }

        // ── Handle image upload ─────────────────────────────────
        $imagePath = '';
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($validated['name']).'.'.$extension;
            $imagePath = $request->file('image')->storeAs($subDir, $filename, 'public');
        }

        // ── Create product ──────────────────────────────────────
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'type' => $validated['type'],
            'price' => $validated['price'],
            'old_price' => $validated['old_price'] ?? null,
            'image_path' => $imagePath,
            'icon' => $validated['icon'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'badge_color' => $validated['badge_color'] ?? null,
            'stocks' => $validated['stocks'] ?? 0,
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
            'product' => $product,
        ]);
    }
}
