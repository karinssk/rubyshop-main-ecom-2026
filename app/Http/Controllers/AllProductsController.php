<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; // Add this import
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Collection;
class AllProductsController extends Controller
{
    /**
     * Display all categories with their products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get main categories (parent_id = 0) that are published
        $categories = ProductCategory::where('status', 'published')
            ->where('parent_id', 0)
            // ->where('is_featured', 0) 
            ->orderBy('order')
            ->get();
        
        // For each category, get a few products
        foreach ($categories as $category) {
            $category->featuredProducts = Product::whereHas('categories', function($query) use ($category) {
                    $query->where('ec_product_category_product.category_id', $category->id);
                })
                ->where('status', 'published')
                ->where('is_variation', 0)
                ->orderBy('created_at', 'desc')
                ->take(4) // Get 4 products per category
                ->get();
        }



        
        
        return view('allproducts', compact('categories'));
    }



 /**
     * Display all categories in a grid layout.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        $allCategories = ProductCategory::where('status', 'published')
            ->orderBy('order')
            ->orderBy('id')
            ->withCount('products')
            ->get();

        $categories = $this->buildCategoryTree($allCategories);

        Theme::layout('full-width');
        Theme::set('pageTitle', __('หมวดหมู่สินค้า'));
        Theme::breadcrumb()
            ->add(__('หน้าหลัก'), route('public.index'))
            ->add(__('หมวดหมู่สินค้า'), url('product-categories'));

        return Theme::scope('custom.product-categories', compact('categories'))->render();
    }

    protected function buildCategoryTree(Collection $allCategories, int $parentId = 0): Collection
    {
        return $allCategories
            ->filter(fn (ProductCategory $category) => (int) $category->parent_id === $parentId)
            ->values()
            ->map(function (ProductCategory $category) use ($allCategories): ProductCategory {
                $category->products_count = (int) ($category->products_count ?? 0);
                $category->subcategories = $this->buildCategoryTree($allCategories, (int) $category->id);

                return $category;
            });
    }




/**
 * Display subcategories for a main category.
 *
 * @param  string  $slug
 * @return \Illuminate\Http\Response
 */
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
    
    return view('sub', compact('mainCategory', 'subcategories'));
}








    /**
     * Display products by category.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function category($slug)
    {
        // Debug the slug
        \Log::info('Category slug: ' . $slug);
        
        try {
            // Find the category by slug
            $category = ProductCategory::where('status', 'published')
                ->where(function($query) use ($slug) {
                    $query->whereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", [strtolower($slug)])
                          ->orWhereRaw("LOWER(REPLACE(name, ' ', '')) = ?", [strtolower(str_replace('-', '', $slug))]);
                })
                ->firstOrFail();
        
            // Debug the found category
            \Log::info('Found category: ' . $category->name . ' (ID: ' . $category->id . ')');
        
            // Get all products in this category
            $products = Product::whereHas('categories', function($query) use ($category) {
                    $query->where('ec_product_category_product.category_id', $category->id);
                })
                ->where('status', 'published')
                ->where('is_variation', 0)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        
            // Debug product count
            \Log::info('Products count: ' . $products->count());
        
            return view('category', compact('category', 'products'));
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in category method: ' . $e->getMessage());
        
            // Return a 404 page
            abort(404, 'Category not found');
        }
    }

    /**
     * Display the specified product.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Try to find the product using different possible identifiers
        $product = Product::where(function($query) use ($slug) {
            // Try different possible ways to identify the product
            $query->where('id', $slug) // In case slug is actually an ID
                  ->orWhereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", [strtolower($slug)]); // Generate slug from name
        })
        ->where('status', 'published')
        ->where('is_variation', 0)
        ->firstOrFail();
    
        // Load product images
        $productImages = [];
        if ($product->images) {
            $images = json_decode($product->images, true);
            foreach ($images as $image) {
                $productImages[] = $image;
            }
        }
    
        // Use the existing product detail template
        return view('platform.themes.wowy.views.ecommerce.product', compact('product', 'productImages'));
    }

    /**
     * Display all product categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function productCategories()
    {
        // Get all published categories
        $categories = ProductCategory::where('status', 'published')
            ->where('parent_id', 0)  // Only main categories
            ->orderBy('order')
            ->get();
        
        // Get subcategories for each main category
        foreach ($categories as $category) {
            $category->subcategories = ProductCategory::where('status', 'published')
                ->where('parent_id', $category->id)
                ->orderBy('order')
                ->get();
            
            // Count products in each category
            $category->products_count = Product::whereHas('categories', function($query) use ($category) {
                    $query->where('ec_product_category_product.category_id', $category->id);
                })
                ->where('status', 'published')
                ->count();
            
            // Count products in each subcategory
            foreach ($category->subcategories as $subcategory) {
                $subcategory->products_count = Product::whereHas('categories', function($query) use ($subcategory) {
                        $query->where('ec_product_category_product.category_id', $subcategory->id);
                    })
                    ->where('status', 'published')
                    ->count();
            }
        }
        
        Theme::layout('full-width');
        Theme::set('pageTitle', __('หมวดหมู่สินค้า'));
        Theme::breadcrumb()
            ->add(__('หน้าหลัก'), route('public.index'))
            ->add(__('หมวดหมู่สินค้า'), url('product-categories'));

        return Theme::scope('custom.product-categories', compact('categories'))->render();
    }
}

// Add this to a temporary route for debugging
\Illuminate\Support\Facades\Route::get('/debug-category', function() {
    $slug = 'tv-videos';
    $category = \App\Models\ProductCategory::where('status', 'published')
        ->where(function($query) use ($slug) {
            $query->whereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", [strtolower($slug)])
                  ->orWhereRaw("LOWER(REPLACE(name, ' ', '')) = ?", [strtolower(str_replace('-', '', $slug))]);
        })
        ->first();
    
    if ($category) {
        return 'Category found: ' . $category->name . ' (ID: ' . $category->id . ')';
    } else {
        return 'Category not found';
    }
});
