<?php

namespace Theme\Wowy\Http\Controllers\Admin;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSortController extends BaseController
{
    public function productsIndex(Request $request)
    {
        $this->pageTitle('Product Sort: Products Page');

        $products = Product::query()
            ->select(['id', 'name', 'sku', 'image', 'price', 'sale_price', 'sort_order_product_page'])
            ->orderByDesc('sort_order_product_page')
            ->orderBy('order')
            ->orderByDesc('id')
            ->paginate(50)
            ->appends($request->query());

        return view('plugins/ecommerce::product-sort.products', compact('products'));
    }

    public function productsUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'sort_order_product_page' => ['nullable', 'array'],
            'sort_order_product_page.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $sorts = (array) $request->input('sort_order_product_page', []);

        if ($sorts) {
            $ids = array_map('intval', array_keys($sorts));
            $products = Product::query()->whereIn('id', $ids)->get();

            foreach ($products as $product) {
                $product->sort_order_product_page = (int) ($sorts[$product->id] ?? 0);
                $product->save();
            }
        }

        return redirect()->route('ecommerce.product-sort.products.index')->with('status', 'Products page sort updated.');
    }

    public function categoriesIndex(Request $request)
    {
        $this->pageTitle('Product Sort: Category Pages');

        $categories = ProductCategory::query()->select(['id', 'name'])->orderBy('name')->get();
        $categoryId = (int) $request->integer('category_id');

        if (! $categoryId && $categories->isNotEmpty()) {
            $categoryId = (int) $categories->first()->id;
        }

        $products = collect();

        if ($categoryId) {
            $products = Product::query()
                ->join('ec_product_category_product as cp', 'cp.product_id', '=', 'ec_products.id')
                ->where('cp.category_id', $categoryId)
                ->select([
                    'ec_products.id',
                    'ec_products.name',
                    'ec_products.sku',
                    'ec_products.image',
                    'ec_products.price',
                    'ec_products.sale_price',
                    DB::raw('COALESCE(cp.sort_order, 0) as category_sort_order'),
                ])
                ->orderByDesc('cp.sort_order')
                ->orderBy('ec_products.order')
                ->orderByDesc('ec_products.id')
                ->paginate(50)
                ->appends($request->query());
        }

        return view('plugins/ecommerce::product-sort.categories', compact('categories', 'categoryId', 'products'));
    }

    public function categoriesUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id' => ['required', 'integer', 'exists:ec_product_categories,id'],
            'sort_order_category_page' => ['nullable', 'array'],
            'sort_order_category_page.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $categoryId = (int) $request->input('category_id');
        $sorts = (array) $request->input('sort_order_category_page', []);

        foreach ($sorts as $productId => $sort) {
            DB::table('ec_product_category_product')
                ->where('category_id', $categoryId)
                ->where('product_id', (int) $productId)
                ->update(['sort_order' => (int) $sort]);
        }

        return redirect()
            ->route('ecommerce.product-sort.categories.index', ['category_id' => $categoryId])
            ->with('status', 'Category page sort updated.');
    }
}
