@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb flex flex-wrap items-center text-sm">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-600">หน้าหลัก</a></li>
            <li class="breadcrumb-item"><a href="{{ url('categories') }}" class="text-gray-500 hover:text-blue-600">หมวดหมู่สินค้า</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span class="text-gray-700">{{ $mainCategory->name }}</span></li>
        </ol>
    </nav>

    <header class="text-center mb-8">
        <h1 class="text-2xl sm:text-3xl font-normal mb-2">{{ $mainCategory->name }}</h1>
        <h2 class="text-lg sm:text-xl font-normal">หมวดหมู่ย่อย</h2>
    </header>
    
 
    
    <div class="product-grid text-center">
        @forelse ($subcategories as $subcategory)
            @php
                $slug = $subcategory->slug ?? strtolower(str_replace(' ', '-', $subcategory->name));
            @endphp
            <article>
                <a href="{{ url('product-categories/' . $slug) }}" class="block category-link">
                    @if ($subcategory->image)
                        <img class="product-image mx-auto" src="{{ asset('storage/' . $subcategory->image) }}" alt="{{ $subcategory->name }}" loading="lazy">
                    @elseif ($subcategory->icon_image)
                        <img class="product-image mx-auto" src="{{ asset('storage/' . $subcategory->icon_image) }}" alt="{{ $subcategory->name }}" loading="lazy">
                    @else
                        <img class="product-image mx-auto" src="{{ asset('images/no-image.jpg') }}" alt="{{ $subcategory->name }}" loading="lazy">
                    @endif
                    <p class="product-title mt-2">{{ $subcategory->name }}</p>
                </a>
            </article>
        @empty
            <div class="col-span-full text-center py-8">
                <p>ไม่พบหมวดหมู่ย่อยในหมวดหมู่นี้</p>
                <a href="{{ url('product-categories/' . ($mainCategory->slug ?? strtolower(str_replace(' ', '-', $mainCategory->name)))) }}" class="btn btn-primary mt-4">ดูสินค้าทั้งหมดในหมวดหมู่นี้</a>
            </div>
        @endforelse
    </div>
    
    <div class="text-center mt-8">
        <a href="{{ url('categories') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-2"></i> กลับไปยังหมวดหมู่ทั้งหมด
        </a>
    </div>
</div>
@endsection


@push('styles')
<style>
    body {
        font-family: "Kanit", sans-serif;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1.5rem;
    }
    
    .product-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    
    .category-link:hover .product-image {
        transform: translateY(-5px);
    }
    
    .product-title {
        margin-top: 0.5rem;
        font-size: 0.875rem;
        line-height: 1.25;
        color: #333;
        transition: color 0.3s ease;
    }
    
    .category-link:hover .product-title {
        color: #007bff;
    }
    
    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-primary {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
    
    .btn-outline-secondary {
        background-color: transparent;
        color: #6c757d;
        border: 1px solid #6c757d;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
    
    @media (max-width: 640px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush