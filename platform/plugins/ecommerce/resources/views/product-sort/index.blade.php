@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <x-core::card>
        <x-core::card.header>
            <x-core::card.title>Product Sort Manager</x-core::card.title>
            <p class="text-muted mb-0">Render as product cards. Higher number shows first (10 before 9).</p>
        </x-core::card.header>

        <x-core::card.body>
            @if (session('status'))
                <x-core::alert type="success" :dismissible="true">
                    {{ session('status') }}
                </x-core::alert>
            @endif

            <form method="post" action="{{ route('ecommerce.product-sort.update') }}">
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Default unsorted (Products page)</label>
                        <input type="number" min="0" name="default_sort_order_product_page" value="0" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Default unsorted (Category pages)</label>
                        <input type="number" min="0" name="default_sort_order_category_page" value="0" class="form-control">
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="apply_default_to_unsorted" value="1">
                            <span class="form-check-label">Apply defaults to products not in current page</span>
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    @foreach ($products as $product)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="text-center mb-3">
                                        <img
                                            src="{{ \Botble\Media\Facades\RvMedia::getImageUrl($product->image, null, false, \Botble\Media\Facades\RvMedia::getDefaultImage()) }}"
                                            alt="{{ $product->name }}"
                                            style="width:100%;height:220px;object-fit:contain;background:#f7f7f8;border-radius:8px;"
                                        >
                                    </div>

                                    <div class="small text-muted mb-1">ID #{{ $product->id }} · {{ $product->sku ?: 'NO-SKU' }}</div>
                                    <div class="fw-semibold mb-2" style="min-height:42px;line-height:1.35;">
                                        <a href="{{ route('products.edit', $product->id) }}" target="_blank">{{ $product->name }}</a>
                                    </div>

                                    <div class="mb-3">
                                        @if ($product->sale_price)
                                            <span class="text-danger fw-bold">{{ format_price($product->sale_price) }}</span>
                                            <span class="text-muted text-decoration-line-through ms-1">{{ format_price($product->price) }}</span>
                                        @else
                                            <span class="text-danger fw-bold">{{ format_price($product->price) }}</span>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        <label class="form-label mb-1">Sort (Products)</label>
                                        <input
                                            type="number"
                                            min="0"
                                            name="sort_order_product_page[{{ $product->id }}]"
                                            value="{{ (int) $product->sort_order_product_page }}"
                                            class="form-control mb-2"
                                        >

                                        <label class="form-label mb-1">Sort (Categories)</label>
                                        <input
                                            type="number"
                                            min="0"
                                            name="sort_order_category_page[{{ $product->id }}]"
                                            value="{{ (int) $product->sort_order_category_page }}"
                                            class="form-control"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex gap-2 mt-4">
                    <x-core::button type="submit" color="primary">Save Sort Orders</x-core::button>
                    <x-core::button tag="a" :href="route('products.index')">Back to Products</x-core::button>
                </div>
            </form>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </x-core::card.body>
    </x-core::card>
@endsection
