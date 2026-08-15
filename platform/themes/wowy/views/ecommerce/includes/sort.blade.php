@php
    $sorts = EcommerceHelper::getSortParams();
    $shows = EcommerceHelper::getShowParams();
    $sortBy = BaseHelper::stringify(request()->input('sort-by', 'default_sorting'));
    $showing = BaseHelper::stringify(request()->integer('num', (int)theme_option('number_of_products_per_page', 12)));
    $sortDebug = request()->attributes->get('ecommerce_sort_debug');
    $normalizedFilterUrl = function (array $query): string {
        $currentQuery = request()->query();
        unset($currentQuery['page']);

        foreach ($query as $key => $value) {
            if ($value === null) {
                unset($currentQuery[$key]);
            } else {
                $currentQuery[$key] = $value;
            }
        }

        $url = request()->url();
        $queryString = http_build_query($currentQuery, '', '&', PHP_QUERY_RFC3986);

        return $queryString
            ? $url . '?' . preg_replace('/((?:categories|brands|tags|attributes)%5B)\\d+(%5D=)/i', '$1$2', $queryString)
            : $url;
    };
@endphp

<div class="sort-by-product-area">
    <div class="sort-by-cover mr-10 products_sortby">
        <div class="sort-by-product-wrap">
            <div class="sort-by">
                <span><i class="fa fa-th"></i>{{ __('Show:') }}</span>
            </div>
            <div class="sort-by-dropdown-wrap">
                <span><span class="sort-by-current-value">{!! Arr::get($shows, $showing, (int)theme_option('number_of_products_per_page', 12)) !!}</span> <i class="far fa-angle-down"></i></span>
            </div>
        </div>
        <div class="sort-by-dropdown products_ajaxsortby" data-name="num">
            <ul>
                @foreach ($shows as $key => $label)
	                    <li>
	                        <a data-label="{{ $label }}"
	                            class="@if ($showing == $key) active @endif"
	                            href="{{ $normalizedFilterUrl(['num' => $key]) }}">{{ $label }}</a>
	                    </li>
	                @endforeach
            </ul>
        </div>
    </div>
    <div class="sort-by-cover products_sortby">
        <div class="sort-by-product-wrap">
            <div class="sort-by">
                <span><i class="fa fa-sort-amount-down"></i>{{ __('Sort by:') }}</span>
            </div>
            <div class="sort-by-dropdown-wrap">
                <span><span class="sort-by-current-value">{!! Arr::get($sorts, $sortBy) !!}</span> <i class="far fa-angle-down"></i></span>
            </div>
        </div>
        <div class="sort-by-dropdown products_ajaxsortby" data-name="sort-by">
            <ul>
                @foreach ($sorts as $key => $label)
	                    <li>
	                        <a data-label="{{ $label }}"
	                        class="@if ($sortBy == $key) active @endif"
	                        href="{{ $normalizedFilterUrl(['sort-by' => $key]) }}">{{ $label }}</a>
	                    </li>
	                @endforeach
            </ul>
        </div>
    </div>
</div>
