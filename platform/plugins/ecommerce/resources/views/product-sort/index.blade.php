@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <x-core::card>
        <x-core::card.header>
            <x-core::card.title>Product Sort Manager</x-core::card.title>
            <p class="text-muted mb-0">Higher number shows first (10 before 9). Separate sort for Products and Category pages.</p>
        </x-core::card.header>

        <x-core::card.body>
            @if (session('status'))
                <x-core::alert type="success" :dismissible="true">
                    {{ session('status') }}
                </x-core::alert>
            @endif

            <form method="post" action="{{ route('ecommerce.product-sort.update') }}">
                @csrf

                <div class="row g-3 mb-3">
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

                <div class="table-responsive">
                    <x-core::table>
                        <x-core::table.header>
                            <x-core::table.header.cell style="width:70px">ID</x-core::table.header.cell>
                            <x-core::table.header.cell style="width:72px">Image</x-core::table.header.cell>
                            <x-core::table.header.cell>Product</x-core::table.header.cell>
                            <x-core::table.header.cell style="width:160px">SKU</x-core::table.header.cell>
                            <x-core::table.header.cell style="width:170px">Sort (Products)</x-core::table.header.cell>
                            <x-core::table.header.cell style="width:170px">Sort (Categories)</x-core::table.header.cell>
                        </x-core::table.header>
                        <x-core::table.body>
                            @foreach ($products as $product)
                                <x-core::table.body.row>
                                    <x-core::table.body.cell>{{ $product->id }}</x-core::table.body.cell>
                                    <x-core::table.body.cell>
                                        <img
                                            src="{{ \Botble\Media\Facades\RvMedia::getImageUrl($product->image, 'thumb', false, \Botble\Media\Facades\RvMedia::getDefaultImage()) }}"
                                            alt="{{ $product->name }}"
                                            style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #ddd;"
                                        >
                                    </x-core::table.body.cell>
                                    <x-core::table.body.cell>
                                        <a href="{{ route('products.edit', $product->id) }}" target="_blank">{{ $product->name }}</a>
                                    </x-core::table.body.cell>
                                    <x-core::table.body.cell>{{ $product->sku ?: '-' }}</x-core::table.body.cell>
                                    <x-core::table.body.cell>
                                        <input
                                            type="number"
                                            min="0"
                                            name="sort_order_product_page[{{ $product->id }}]"
                                            value="{{ (int) $product->sort_order_product_page }}"
                                            class="form-control"
                                        >
                                    </x-core::table.body.cell>
                                    <x-core::table.body.cell>
                                        <input
                                            type="number"
                                            min="0"
                                            name="sort_order_category_page[{{ $product->id }}]"
                                            value="{{ (int) $product->sort_order_category_page }}"
                                            class="form-control"
                                        >
                                    </x-core::table.body.cell>
                                </x-core::table.body.row>
                            @endforeach
                        </x-core::table.body>
                    </x-core::table>
                </div>

                <div class="d-flex gap-2 mt-3">
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
