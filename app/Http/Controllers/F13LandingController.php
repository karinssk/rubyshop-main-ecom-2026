<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class F13LandingController extends Controller
{
    public function show(): View
    {
        $product = DB::table('ec_products')
            ->where('sku', 'POS-35169305')
            ->where('status', 'published')
            ->first(['name', 'sku', 'price', 'quantity']);

        abort_unless($product, 404);

        return view('landing.f13-google-ads', [
            'product' => $product,
            'price' => number_format((float) $product->price, 0),
            'inStock' => (int) $product->quantity > 0,
        ]);
    }
}
