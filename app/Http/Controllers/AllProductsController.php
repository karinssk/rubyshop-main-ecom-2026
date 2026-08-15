<?php

namespace App\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\Product as EcommerceProduct;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Services\Products\GetProductService;
use Botble\Media\Facades\RvMedia;
use Illuminate\Http\Request;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
        Theme::set('hasBreadcrumb', false);

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
            // Find the category by Botble slug relation. ec_product_categories has no direct slug column.
            $category = ProductCategory::query()
                ->wherePublished()
                ->with(['slugable', 'activeChildren', 'activeChildren.slugable'])
                ->where(function($query) use ($slug) {
                    $query->whereHas('slugable', function ($query) use ($slug) {
                            $query->where('key', $slug);
                        })
                        ->orWhereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", [strtolower($slug)])
                        ->orWhereRaw("LOWER(REPLACE(name, ' ', '')) = ?", [strtolower(str_replace('-', '', $slug))]);
                })
                ->firstOrFail();
        
            // Debug the found category
            \Log::info('Found category: ' . $category->name . ' (ID: ' . $category->id . ')');

            // Collect parent + all descendant category IDs so subcategory products appear on the parent page
            $allCategoryIds = collect([$category->getKey()]);
            $toProcess = collect([$category->getKey()]);
            while ($toProcess->isNotEmpty()) {
                $children = ProductCategory::whereIn('parent_id', $toProcess->toArray())
                    ->wherePublished()
                    ->pluck('id');
                $allCategoryIds = $allCategoryIds->merge($children);
                $toProcess = $children;
            }

            $request = request();
            $request->merge([
                'categories' => array_unique(array_merge(
                    (array) $request->input('categories', []),
                    $allCategoryIds->toArray()
                )),
            ]);

            $products = app(GetProductService::class)->getProduct(
                $request,
                $category->getKey(),
                null,
                EcommerceHelper::withProductEagerLoadingRelations()
            );
        
            // Debug product count
            \Log::info('Products count: ' . $products->count());
        
            SeoHelper::setTitle($category->name)->setDescription($category->description);
            SeoHelper::meta()->setUrl($category->url);

            Theme::layout('full-width');
            Theme::breadcrumb()
                ->add(__('Products'), route('public.products'))
                ->add($category->name, $category->url);

            return Theme::scope(
                'ecommerce.product-category',
                compact('category', 'products'),
                'plugins/ecommerce::themes.product-category'
            )->render();
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
        $product = is_numeric($slug) ? get_products([
            'condition' => [
                'ec_products.id' => $slug,
                'ec_products.status' => BaseStatusEnum::PUBLISHED,
                'ec_products.is_variation' => 0,
            ],
            'take' => 1,
            'with' => array_merge([
                'slugable',
                'brand',
                'categories',
                'tags',
                'productLabels',
                'defaultVariation',
                'variations',
            ], EcommerceHelper::withProductEagerLoadingRelations()),
            ...EcommerceHelper::withReviewsParams(),
        ]) : null;

        if (! $product) {
            $product = EcommerceProduct::query()
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->where('is_variation', 0)
                ->where(function ($query) use ($slug) {
                    $query->where('id', $slug)
                        ->orWhereHas('slugable', function ($query) use ($slug) {
                            $query->where('key', $slug);
                        })
                        ->orWhereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", [strtolower($slug)]);
                })
                ->with([
                    'slugable',
                    'brand',
                    'categories',
                    'tags',
                    'productLabels',
                    'defaultVariation',
                    'variations',
                ])
                ->withCount(['reviews'])
                ->firstOrFail();
        }

        [$productImages, , $selectedAttrs] = EcommerceHelper::getProductVariationInfo($product);

        // fallback: ถ้า images array ว่าง ให้ใช้ image field แทน
        if (empty($productImages) && $product->image) {
            $productImages = [$product->image];
        }

        $productSlug = $this->getProductSlug($product, $slug);
        $productCanonicalUrl = route('product.detail.slug', ['slug' => $productSlug]);

        if (request()->path() !== 'products/' . $productSlug) {
            return redirect()->to($productCanonicalUrl, 301);
        }

        $seoDescription = $this->getProductSeoDescription($product);
        $seoImage = RvMedia::getImageUrl($product->image, 'medium', false, RvMedia::getDefaultImage());

        Theme::layout('product-right-sidebar');
        Theme::set('pageTitle', $product->name);
        Theme::breadcrumb()
            ->add(__('Products'), route('public.products'))
            ->add($product->name, $productCanonicalUrl);

        SeoHelper::setTitle($product->name . ' | RUBYSHOP')
            ->setDescription($seoDescription)
            ->setImage($seoImage);

        SeoHelper::meta()->setUrl($productCanonicalUrl);
        SeoHelper::openGraph()
            ->setUrl($productCanonicalUrl)
            ->setType('product');

        return Theme::scope('ecommerce.product', compact('product', 'productImages', 'selectedAttrs', 'productCanonicalUrl', 'seoDescription'))->render();
    }

    protected function getProductSlug(EcommerceProduct $product, string $fallback): string
    {
        return (string) ($product->slug ?: $product->slugable?->key ?: $fallback);
    }

    protected function getProductSeoDescription(EcommerceProduct $product): string
    {
        $description = trim(strip_tags(BaseHelper::clean((string) ($product->description ?: $product->content))));

        if (! $description) {
            $description = $product->name . ' จาก RUBYSHOP เครื่องมือช่างและอุปกรณ์สำหรับงานมืออาชีพ';
        }

        return Str::limit($description, 155, '');
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
        Theme::set('hasBreadcrumb', false);

        return Theme::scope('custom.product-categories', compact('categories'))->render();
    }
}
