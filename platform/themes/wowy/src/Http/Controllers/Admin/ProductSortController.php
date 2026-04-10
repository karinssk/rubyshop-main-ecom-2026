<?php

namespace Theme\Wowy\Http\Controllers\Admin;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductSortController extends BaseController
{
    public function index(Request $request): Response
    {
        $products = Product::query()
            ->select(['id', 'name', 'sku', 'sort_order_product_page', 'sort_order_category_page', 'order'])
            ->orderByDesc('sort_order_product_page')
            ->orderByDesc('sort_order_category_page')
            ->orderBy('order')
            ->orderByDesc('id')
            ->paginate(200)
            ->appends($request->query());

        $status = session('status');

        $rows = '';

        foreach ($products as $product) {
            $rows .= sprintf(
                '<tr>
                    <td style="padding:8px;border:1px solid #ddd;">%d</td>
                    <td style="padding:8px;border:1px solid #ddd;">%s</td>
                    <td style="padding:8px;border:1px solid #ddd;">%s</td>
                    <td style="padding:8px;border:1px solid #ddd;"><input type="number" min="0" name="sort_order_product_page[%d]" value="%d" style="width:110px;padding:6px;"></td>
                    <td style="padding:8px;border:1px solid #ddd;"><input type="number" min="0" name="sort_order_category_page[%d]" value="%d" style="width:110px;padding:6px;"></td>
                </tr>',
                $product->id,
                e($product->name),
                e((string) ($product->sku ?: '-')),
                $product->id,
                (int) $product->sort_order_product_page,
                $product->id,
                (int) $product->sort_order_category_page
            );
        }

        $messageBox = $status
            ? '<div style="background:#e7f7ed;border:1px solid #9ad9b0;padding:10px 12px;margin-bottom:12px;border-radius:6px;">' . e($status) . '</div>'
            : '';

        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Sort Manager</title>
</head>
<body style="font-family:Arial,sans-serif;margin:20px;background:#f7f8fa;">
    <div style="max-width:1280px;margin:0 auto;background:#fff;border:1px solid #ddd;border-radius:8px;padding:16px;">
        <h2 style="margin:0 0 12px;">Product Sort Manager</h2>
        <p style="margin:0 0 14px;color:#555;">Set custom sort numbers. Higher number shows first (10 before 9).</p>
        ' . $messageBox . '

        <form method="post" action="' . e(route('ecommerce.product-sort.update')) . '">
            <input type="hidden" name="_token" value="' . e(csrf_token()) . '">

            <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:14px;padding:10px;background:#fafafa;border:1px solid #eee;border-radius:6px;">
                <label>Default for unsorted (Products page):
                    <input type="number" min="0" name="default_sort_order_product_page" value="0" style="width:100px;margin-left:6px;padding:6px;">
                </label>
                <label>Default for unsorted (Category pages):
                    <input type="number" min="0" name="default_sort_order_category_page" value="0" style="width:100px;margin-left:6px;padding:6px;">
                </label>
                <label style="display:flex;align-items:center;gap:6px;">
                    <input type="checkbox" name="apply_default_to_unsorted" value="1"> Apply defaults to products not in this page selection
                </label>
            </div>

            <div style="overflow:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:14px;">
                    <thead>
                        <tr style="background:#f1f3f5;">
                            <th style="padding:8px;border:1px solid #ddd;text-align:left;">ID</th>
                            <th style="padding:8px;border:1px solid #ddd;text-align:left;">Product</th>
                            <th style="padding:8px;border:1px solid #ddd;text-align:left;">SKU</th>
                            <th style="padding:8px;border:1px solid #ddd;text-align:left;">Sort (Products)</th>
                            <th style="padding:8px;border:1px solid #ddd;text-align:left;">Sort (Categories)</th>
                        </tr>
                    </thead>
                    <tbody>' . $rows . '</tbody>
                </table>
            </div>

            <div style="margin-top:14px;display:flex;gap:8px;align-items:center;">
                <button type="submit" style="background:#0d6efd;color:#fff;border:0;padding:9px 14px;border-radius:6px;cursor:pointer;">Save Sort Orders</button>
                <a href="' . e(route('products.index')) . '" style="text-decoration:none;color:#333;">Back to Products</a>
            </div>
        </form>

        <div style="margin-top:14px;">' . $products->links()->toHtml() . '</div>
    </div>
</body>
</html>';

        return response($html);
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
            ->with('status', __('Product sort orders updated successfully.'));
    }
}
