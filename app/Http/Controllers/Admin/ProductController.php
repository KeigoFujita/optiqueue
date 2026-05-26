<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
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
}
