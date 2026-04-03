<div class="card h-100">
    @if ($product->images)
        @php
            $images = json_decode($product->images, true);
            $firstImage = $images[0] ?? null;
        @endphp
        @if ($firstImage)
            <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy" style="height: 200px; object-fit: cover;">
        @else
            <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No Image" loading="lazy" style="height: 200px; object-fit: cover;">
        @endif
    @else
        <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No Image" loading="lazy" style="height: 200px; object-fit: cover;">
    @endif
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <div class="d-flex justify-content-between align-items-center">
            <div class="price-box">
                @if ($product->sale_price)
                    <span class="text-muted text-decoration-line-through">฿{{ number_format($product->price, 2) }}</span>
                    <span class="text-danger">฿{{ number_format($product->sale_price, 2) }}</span>
                @else
                    <span>฿{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-primary w-100">View Details</a>
    </div>
</div>
