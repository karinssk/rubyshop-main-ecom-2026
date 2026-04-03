@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row mt-4">
        <div class="col-md-6">
            @if ($product->images)
                @php
                    $images = json_decode($product->images, true);
                    $firstImage = $images[0] ?? null;
                @endphp
                @if ($firstImage)
                    <img src="{{ asset($firstImage) }}" class="img-fluid" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid" alt="No Image">
                @endif
            @else
                <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid" alt="No Image">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            
            <div class="mb-3">
                @if ($product->sale_price)
                    <span class="text-muted text-decoration-line-through fs-4">${{ number_format($product->price, 2) }}</span>
                    <span class="text-danger fs-3">${{ number_format($product->sale_price, 2) }}</span>
                @else
                    <span class="fs-3">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            
            <div class="mb-3">
                @if ($product->stock_status === 'in_stock')
                    <span class="badge bg-success">In Stock</span>
                @else
                    <span class="badge bg-danger">Out of Stock</span>
                @endif
                
                @if ($product->sku)
                    <span class="ms-2">SKU: {{ $product->sku }}</span>
                @endif
            </div>
            
            <div class="mb-4">
                <p>{{ $product->description }}</p>
            </div>
            
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="button">Add to Cart</button>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <h3>Product Details</h3>
            <hr>
            <div>
                {!! $product->content !!}
            </div>
        </div>
    </div>
</div>
@endsection