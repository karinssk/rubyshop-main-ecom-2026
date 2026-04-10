@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <x-core::card>
        <x-core::card.header>
            <x-core::card.title>Sort for Category Pages</x-core::card.title>
            <div class="d-flex gap-2">
                <x-core::button tag="a" :href="route('ecommerce.product-sort.products.index')">Products Page</x-core::button>
                <x-core::button tag="a" :href="route('ecommerce.product-sort.categories.index')" color="primary">Category Pages</x-core::button>
            </div>
        </x-core::card.header>
        <x-core::card.body>
            @if (session('status'))<x-core::alert type="success" :dismissible="true">{{ session('status') }}</x-core::alert>@endif

            <form method="get" class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category_id" onchange="this.form.submit()">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected((int)$cat->id === (int)$categoryId)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </form>

            @if($categoryId)
            <form method="post" action="{{ route('ecommerce.product-sort.categories.update') }}">
                @csrf
                <input type="hidden" name="category_id" value="{{ $categoryId }}">
                <p class="text-muted">Drag and drop cards for this category. Top = highest priority.</p>
                <div class="row g-3" id="sortable-category-products">
                    @foreach ($products as $product)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3" draggable="true" data-product-id="{{ $product->id }}">
                            <div class="card h-100">
                                <div class="card-body">
                                    <img src="{{ \Botble\Media\Facades\RvMedia::getImageUrl($product->image, null, false, \Botble\Media\Facades\RvMedia::getDefaultImage()) }}" style="width:100%;height:180px;object-fit:contain;background:#f7f7f8;border-radius:8px;">
                                    <div class="mt-2 fw-semibold">{{ $product->name }}</div>
                                    <div class="text-muted small">#{{ $product->id }} · {{ $product->sku ?: 'NO-SKU' }}</div>
                                    <label class="form-label mt-2 mb-1">Sort (This Category)</label>
                                    <input type="number" min="0" name="sort_order_category_page[{{ $product->id }}]" value="{{ (int) $product->category_sort_order }}" class="form-control sort-input">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <x-core::button class="mt-3" type="submit" color="primary">Save</x-core::button>
            </form>
            <div class="mt-3">{{ $products->links() }}</div>
            @endif
        </x-core::card.body>
    </x-core::card>

    <script>
        (() => {
            const container = document.getElementById('sortable-category-products');
            if (!container) return;
            let dragging = null;
            container.querySelectorAll('[draggable="true"]').forEach(card => {
                card.addEventListener('dragstart', () => { dragging = card; card.classList.add('opacity-50'); });
                card.addEventListener('dragend', () => { card.classList.remove('opacity-50'); dragging = null; updateRanks(); });
                card.addEventListener('dragover', (e) => { e.preventDefault(); });
                card.addEventListener('drop', (e) => {
                    e.preventDefault();
                    if (!dragging || dragging === card) return;
                    const rect = card.getBoundingClientRect();
                    const after = (e.clientY - rect.top) > rect.height / 2;
                    container.insertBefore(dragging, after ? card.nextSibling : card);
                });
            });
            function updateRanks() {
                const cards = [...container.querySelectorAll('[draggable="true"]')];
                let rank = cards.length;
                cards.forEach(card => {
                    const input = card.querySelector('.sort-input');
                    if (input) input.value = rank--;
                });
            }
        })();
    </script>
@endsection
