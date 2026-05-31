<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $products = Product::all();

        $totalFrames = $products->where('type', 'frame')->sum('stocks');
        $totalLenses = $products->where('type', 'lens')->sum('stocks');
        $totalAccessories = $products->where('type', 'accessory')->sum('stocks');
        $totalItems = $products->sum('stocks');

        $lowStockProducts = $products->where('stocks', '<', 20);

        $movements = ProductMovement::with('product')
            ->orderBy('movement_date', 'desc')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return view('admin.inventory', compact(
            'products', 'totalFrames', 'totalLenses', 'totalAccessories', 'totalItems',
            'lowStockProducts', 'movements'
        ));
    }
}