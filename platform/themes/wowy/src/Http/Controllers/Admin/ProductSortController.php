<?php

namespace Theme\Wowy\Http\Controllers\Admin;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductSortController extends BaseController
{
    public function index(Request $request)
    {
        $this->pageTitle('Product Sort Manager');

        $products = Product::query()
            ->select(['id', 'name', 'sku', 'image', 'price', 'sale_price', 'sort_order_product_page', 'sort_order_category_page', 'order'])
            ->orderByDesc('sort_order_product_page')
            ->orderByDesc('sort_order_category_page')
            ->orderBy('order')
            ->orderByDesc('id')
            ->paginate(50)
            ->appends($request->query());

        return view('plugins/ecommerce::product-sort.index', compact('products'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'sort_order_product_page' => ['nullable', 'array'],
            'sort_order_product_page.*' => ['nullable', 'integer', 'min:0'],
            'sort_order_category_page' => ['nullable', 'array'],
            'sort_order_category_page.*' => ['nullable', 'integer', 'min:0'],
            'default_sort_order_product_page' => ['nullable', 'integer', 'min:0'],
            'default_sort_order_category_page' => ['nullable', 'integer', 'min:0'],
            'apply_default_to_unsorted' => ['nullable', 'in:1'],
        ]);

        $productSorts = array_map('intval', (array) $request->input('sort_order_product_page', []));
        $categorySorts = array_map('intval', (array) $request->input('sort_order_category_page', []));

        $ids = array_values(array_unique(array_merge(array_keys($productSorts), array_keys($categorySorts))));

        if ($ids) {
            $products = Product::query()->whereIn('id', $ids)->get();

            foreach ($products as $product) {
                if (array_key_exists((string) $product->id, $productSorts) || array_key_exists($product->id, $productSorts)) {
                    $product->sort_order_product_page = (int) ($productSorts[$product->id] ?? $productSorts[(string) $product->id] ?? 0);
                }

                if (array_key_exists((string) $product->id, $categorySorts) || array_key_exists($product->id, $categorySorts)) {
                    $product->sort_order_category_page = (int) ($categorySorts[$product->id] ?? $categorySorts[(string) $product->id] ?? 0);
                }

                $product->save();
            }
        }

        if ((int) $request->input('apply_default_to_unsorted') === 1) {
            $defaultUpdates = [];

            if ($request->filled('default_sort_order_product_page')) {
                $defaultUpdates['sort_order_product_page'] = (int) $request->input('default_sort_order_product_page');
            }

            if ($request->filled('default_sort_order_category_page')) {
                $defaultUpdates['sort_order_category_page'] = (int) $request->input('default_sort_order_category_page');
            }

            if ($defaultUpdates) {
                $query = Product::query();

                if ($ids) {
                    $query->whereNotIn('id', $ids);
                }

                $query->update($defaultUpdates);
            }
        }

        return redirect()
            ->route('ecommerce.product-sort.index')
            ->with('status', 'Product sort orders updated successfully.');
    }
}
