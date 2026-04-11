@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <x-core::card>
        <x-core::card.header>
            <x-core::card.title>Landing Page Builder</x-core::card.title>
            <p class="text-muted mb-0">Manage landing sections in a standalone admin page, separate from product detail form.</p>
        </x-core::card.header>

        <x-core::card.body>
            @if (session('status'))
                <x-core::alert type="success" :dismissible="true">
                    {{ session('status') }}
                </x-core::alert>
            @endif

            <form method="get" action="{{ route('ecommerce.landing-builder.index') }}" class="mb-4">
                <div class="row g-2 align-items-end">
                    <div class="col-md-8 col-lg-6">
                        <label class="form-label">Select product</label>
                        <select name="product_id" class="form-select">
                            <option value="">-- choose product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected($selectedProduct && $selectedProduct->id === $product->id)>
                                    #{{ $product->id }} - {{ $product->name }}{{ $product->sku ? ' (' . $product->sku . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <x-core::button type="submit" color="primary">Load</x-core::button>
                    </div>
                </div>
            </form>

            @if ($selectedProduct)
                @php
                    $previewUrl = $selectedProduct->slug ? route('landing.product', ['slug' => $selectedProduct->slug]) : null;
                @endphp

                <div class="mb-3 small text-muted">
                    Editing landing page for:
                    <strong>{{ $selectedProduct->name }}</strong>
                    @if ($previewUrl)
                        · Preview:
                        <a href="{{ $previewUrl }}" target="_blank">
                            {{ $previewUrl }}
                        </a>
                    @endif
                </div>

                <div class="row g-2 align-items-stretch">
                    <div class="col-12 col-xl-4">
                        <form method="post" action="{{ route('ecommerce.landing-builder.update', $selectedProduct->id) }}">
                            @csrf

                            {!! Theme::partial('landing-page-builder-fields', ['landingSections' => $landingSections, 'selectedProduct' => $selectedProduct]) !!}

                            <div class="d-flex gap-2">
                                <x-core::button type="submit" color="primary">Save Landing Sections</x-core::button>
                                @if ($previewUrl)
                                    <x-core::button type="button" color="secondary" id="refresh-landing-preview">Refresh Preview</x-core::button>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if ($previewUrl)
                        <div class="col-12 col-xl-8">
                            <x-core::card>
                                <x-core::card.header>
                                    <x-core::card.title>Live Landing Preview</x-core::card.title>
                                    <p class="text-muted mb-0">Save changes, then click refresh to see latest render.</p>
                                </x-core::card.header>
                                <x-core::card.body>
                                    <iframe
                                        id="landing-preview-frame"
                                        src="{{ $previewUrl }}"
                                        style="width:100%;height:88vh;border:1px solid #e5e7eb;border-radius:8px;background:#fff;"
                                        loading="lazy"
                                    ></iframe>
                                </x-core::card.body>
                            </x-core::card>
                        </div>
                    @endif
                </div>
            @else
                <x-core::alert type="info">
                    Choose a product to start editing its landing page sections.
                </x-core::alert>
            @endif
        </x-core::card.body>
    </x-core::card>

    @if (! empty($previewUrl))
        <script>
            (() => {
                const refreshButton = document.getElementById('refresh-landing-preview');
                const previewFrame = document.getElementById('landing-preview-frame');

                if (! refreshButton || ! previewFrame) {
                    return;
                }

                refreshButton.addEventListener('click', () => {
                    const separator = previewFrame.src.includes('?') ? '&' : '?';
                    previewFrame.src = previewFrame.src.split('?')[0] + separator + 'preview_ts=' + Date.now();
                });
            })();
        </script>
    @endif

    <style>
        /* Force this admin screen to use full width instead of container-xl */
        .container-xl {
            max-width: 100% !important;
            width: 100% !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .content .card .card-body {
            padding: 12px;
        }

        #landing-sections-list .landing-section-item {
            margin-bottom: 8px;
        }
    </style>
@endsection
