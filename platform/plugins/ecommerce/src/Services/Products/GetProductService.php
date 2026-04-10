<?php

namespace Botble\Ecommerce\Services\Products;

use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GetProductService
{
    public function __construct(protected ProductInterface $productRepository)
    {
    }

    public function getProduct(
        Request $request,
        $category = null,
        $brand = null,
        array $with = [],
        array $withCount = [],
        array $conditions = []
    ): Collection|LengthAwarePaginator {
        $num = $request->integer('num') ?: $request->integer('per-page');
        $shows = EcommerceHelper::getShowParams();

        if (! array_key_exists($num, $shows)) {
            $num = (int) theme_option('number_of_products_per_page', 12);
        }

        $queryVar = [
            'keyword' => BaseHelper::stringify($request->input('q')),
            'brands' => (array) $request->input('brands', []),
            'categories' => (array) $request->input('categories', []),
            'tags' => (array) $request->input('tags', []),
            'collections' => (array) $request->input('collections', []),
            'collection' => $request->input('collection'),
            'attributes' => (array) $request->input('attributes', []),
            'max_price' => $request->input('max_price'),
            'min_price' => $request->input('min_price'),
            'price_ranges' => (array) $request->input('price_ranges', []),
            'sort_by' => $request->input('sort-by'),
            'num' => $num,
        ];

        if ($category) {
            $queryVar['categories'] = array_merge($queryVar['categories'], [$category]);
            $queryVar['single_category_id_for_sort'] = (int) $category;
        }

        if ($brand) {
            $queryVar['brands'] = array_merge(($queryVar['brands']), [$brand]);
        }

        $contextSortColumn = $category
            ? 'category_sort_order'
            : 'ec_products.sort_order_product_page';

        $orderBy = [
            $contextSortColumn => 'DESC',
            'ec_products.order' => 'ASC',
            'ec_products.created_at' => 'DESC',
        ];

        if (! EcommerceHelper::isReviewEnabled() && in_array($queryVar['sort_by'], ['rating_asc', 'rating_desc'])) {
            $queryVar['sort_by'] = 'date_desc';
        }

        $params = array_merge([
            'paginate' => [
                'per_page' => $queryVar['num'],
                'current_paged' => $request->integer('page', 1) ?: 1,
            ],
            'with' => array_merge(EcommerceHelper::withProductEagerLoadingRelations(), $with),
            'withCount' => $withCount,
        ], EcommerceHelper::withReviewsParams());

        switch ($queryVar['sort_by']) {
            case 'date_asc':
                $orderBy = [
                    'ec_products.created_at' => 'ASC',
                ];

                break;
            case 'date_desc':
                $orderBy = [
                    'ec_products.created_at' => 'DESC',
                ];

                break;
            case 'price_asc':
                $orderBy = [
                    'products_with_final_price.final_price' => 'ASC',
                ];

                break;
            case 'price_desc':
                $orderBy = [
                    'products_with_final_price.final_price' => 'DESC',
                ];

                break;
            case 'name_asc':
                $orderBy = [
                    'ec_products.name' => 'ASC',
                ];

                break;
            case 'name_desc':
                $orderBy = [
                    'ec_products.name' => 'DESC',
                ];

                break;
            case 'rating_asc':
                if (EcommerceHelper::isReviewEnabled()) {
                    $orderBy = [
                        'reviews_avg' => 'ASC',
                    ];
                }

                break;
            case 'rating_desc':
                if (EcommerceHelper::isReviewEnabled()) {
                    $orderBy = [
                        'reviews_avg' => 'DESC',
                    ];
                }

                break;
        }

        if (! empty($conditions)) {
            $params['condition'] = $conditions;
        }

        $legacyOrderBy = [
            'ec_products.order' => 'ASC',
            'ec_products.created_at' => 'DESC',
        ];

        $request->attributes->set('ecommerce_sort_debug', [
            'path' => $request->path(),
            'full_url' => $request->fullUrl(),
            'sort_by' => $queryVar['sort_by'] ?: 'default_sorting',
            'category_context_id' => $queryVar['single_category_id_for_sort'] ?? null,
            'selected_order_by' => $orderBy,
            'legacy_order_by' => $legacyOrderBy,
            'categories_filter' => $queryVar['categories'],
        ]);

        $products = $this->productRepository->filterProducts([
            'keyword' => $queryVar['keyword'],
            'min_price' => $queryVar['min_price'],
            'max_price' => $queryVar['max_price'],
            'price_ranges' => array_values($queryVar['price_ranges']),
            'categories' => $queryVar['categories'],
            'single_category_id_for_sort' => $queryVar['single_category_id_for_sort'] ?? null,
            'tags' => $queryVar['tags'],
            'collections' => $queryVar['collections'],
            'collection' => $queryVar['collection'],
            'brands' => $queryVar['brands'],
            'attributes' => $queryVar['attributes'],
            'order_by' => $orderBy,
        ], $params);

        if ($keyword = $queryVar['keyword']) {
            $products->setCollection(BaseHelper::sortSearchResults($products->getCollection(), $keyword, 'name'));
        }

        return $products;
    }
}
