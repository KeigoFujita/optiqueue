<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display the place-order page with product details calculated.
     *
     * Expects query parameters: frame_id, lens_id, accessory_id
     */
    public function placeOrder(Request $request)
    {
        $frameId = $request->query('frame_id');
        $lensId = $request->query('lens_id');
        $accessoryId = $request->query('accessory_id');

        // Look up products from the database
        $frame = $frameId ? Product::find($frameId) : null;
        $lens = $lensId ? Product::find($lensId) : null;
        $accessory = $accessoryId ? Product::find($accessoryId) : null;

        // Calculate prices
        $framePrice = $frame ? (int) $frame->price : 0;
        $lensPrice = $lens ? (int) $lens->price : 0;
        $accessoryPrice = $accessory ? (int) $accessory->price : 0;
        $total = $framePrice + $lensPrice + $accessoryPrice;

        return view('place-order', [
            'frame' => $frame,
            'lens' => $lens,
            'accessory' => $accessory,
            'framePrice' => $framePrice,
            'lensPrice' => $lensPrice,
            'accessoryPrice' => $accessoryPrice,
            'total' => $total,
        ]);
    }
}
