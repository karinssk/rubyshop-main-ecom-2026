<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('status', 'published')
            ->where('is_variation', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Display the specified product.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Find the product by converting slug back to a name-like format
        $product = Product::where('name', 'like', str_replace('-', '%', $slug))
            ->orWhere('name', 'like', str_replace('-', ' ', $slug))
            ->firstOrFail();
        
        // Increment view count
        $product->increment('views');
        
        // Get product images
        $productImages = [];
        if ($product->images) {
            $images = json_decode($product->images, true);
            if (is_array($images) && count($images) > 0) {
                $productImages = $images;
            }
        }
        
        if (empty($productImages) && $product->image) {
            $productImages = [$product->image];
        }
        
        // Get selected attributes (if needed)
        $selectedAttrs = [];
        
        // If your view is in resources/views/platform/themes/wowy/views/ecommerce/product.blade.php
        return view('products.show', compact('product', 'productImages', 'selectedAttrs'));

        // OR if your view is directly in platform/themes/wowy/views/ecommerce/product.blade.php
        // You might need to create a custom view finder or copy the view to resources/views
    }
}
