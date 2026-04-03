<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; // Add this import
class CatController extends Controller
{
    public function mainCategory($slug)
    {
        // Find the main category by slug
        $mainCategory = ProductCategory::where('status', 'published')
            ->where('parent_id', 0)
            ->where(function($query) use ($slug) {
                $query->whereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", [strtolower($slug)])
                    ->orWhereRaw("LOWER(REPLACE(name, ' ', '')) = ?", [strtolower(str_replace('-', '', $slug))]);
            })
            ->firstOrFail();
        
        // Get all subcategories for this main category
        $subcategories = ProductCategory::where('status', 'published')
            ->where('parent_id', $mainCategory->id)
            ->orderBy('order')
            ->get();
        
        // Debug information
        \Log::info('Main Category: ' . $mainCategory->name . ' (ID: ' . $mainCategory->id . ')');
        \Log::info('Subcategories count: ' . $subcategories->count());
        
        return view('subcat2', compact('mainCategory', 'subcategories'));
    }


}











































































































































































































































