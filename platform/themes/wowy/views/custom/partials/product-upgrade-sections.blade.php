@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// Get related products in same category
$catId = DB::table('ec_product_category_product')->where('product_id', $product->id)->value('category_id');
$compareProducts = collect();
if ($catId) {
    $slugMap = DB::table('slugs')->where('reference_type','like','%Product%')->pluck('key','reference_id');
    $compareProducts = DB::table('ec_products as p')
        ->join('ec_product_category_product as pcp','pcp.product_id','=','p.id')
        ->where('pcp.category_id', $catId)
        ->where('p.id', '!=', $product->id)
        ->where('p.status','published')
        ->where('p.is_variation', 0)
        ->orderByDesc('p.price')
        ->limit(3)
        ->get(['p.id','p.name','p.price','p.image']);
    $compareProducts = $compareProducts->map(function($p) use ($slugMap) {
        $p->slug = $slugMap[$p->id] ?? null;
        return $p;
    })->filter(fn($p) => $p->slug);
}
@endphp

<style>
  .product-cta-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #8b0000, #b40c00);
    border-radius: 8px;
    color: #fff;
  }

  .product-compare-section__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
  }

  .product-compare-section__card {
    display: block;
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 12px;
    color: inherit;
    text-decoration: none;
    transition: box-shadow .2s;
  }

  .product-compare-section__card:hover {
    color: inherit;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
  }

  .product-compare-section__image {
    width: 100%;
    height: 120px;
    object-fit: contain;
    margin-bottom: 8px;
  }

  .product-compare-section__name {
    display: -webkit-box;
    min-height: 38px;
    margin-bottom: 4px;
    overflow: hidden;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    font-size: .85rem;
    font-weight: 600;
    line-height: 1.35;
  }

  .product-compare-section__price {
    color: #e74c3c;
    font-weight: 700;
  }

  .product-cta-section__title {
    max-width: 760px;
    margin: 0;
    color: #fff;
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.45;
    overflow-wrap: break-word;
  }

  .product-cta-section__actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    width: 100%;
  }

  .product-cta-section__button {
    display: inline-flex;
    min-height: 44px;
    min-width: 150px;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 2px solid rgba(255, 255, 255, .5);
    border-radius: 25px;
    color: #fff;
    font-weight: 700;
    line-height: 1.2;
    padding: 10px 24px;
    text-align: center;
    text-decoration: none;
    white-space: nowrap;
  }

  .product-cta-section__button:hover {
    color: #fff;
    border-color: rgba(255, 255, 255, .75);
    text-decoration: none;
  }

  .product-cta-section__button svg {
    flex: 0 0 auto;
  }

  .product-cta-section__button--line {
    background: rgba(255, 255, 255, .2);
  }

  .product-cta-section__button--phone {
    background: rgba(255, 255, 255, .15);
  }

  @media (max-width: 575px) {
    .product-compare-section__grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 10px;
    }

    .product-compare-section__card {
      padding: 8px;
    }

    .product-compare-section__image {
      height: clamp(92px, 30vw, 120px);
    }

    .product-compare-section__name {
      min-height: 34px;
      font-size: 12px;
    }

    .product-compare-section__price {
      font-size: 13px;
    }

    .product-cta-section {
      align-items: stretch;
      padding: 18px 14px !important;
      text-align: center;
    }

    .product-cta-section__title {
      font-size: 1rem;
    }

    .product-cta-section__actions {
      flex-direction: column;
      gap: 8px;
    }

    .product-cta-section__button {
      width: 100%;
      min-width: 0;
      border-radius: 10px;
      padding: 11px 14px;
      white-space: normal;
    }
  }
</style>

{{-- เหมาะกับงานแบบไหน --}}
<div class="product-upgrade-section mt-5 p-4" style="background:#f8f9fa;border-radius:8px;">
  <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:1rem;">{{ $product->name }} เหมาะกับงานแบบไหน?</h2>
  <div style="color:#555;line-height:1.8;">
    {!! nl2br(e(Str::limit(strip_tags($product->content ?: $product->description ?: ''), 400))) !!}
  </div>
</div>

{{-- รุ่นใกล้เคียง --}}
@if($compareProducts->count() > 0)
<div class="product-compare-section mt-4">
  <h2 style="font-size:1.2rem;font-weight:700;margin-bottom:1rem;">รุ่นใกล้เคียงที่น่าสนใจ</h2>
  <div class="product-compare-section__grid">
    @foreach($compareProducts as $cp)
    <a class="product-compare-section__card" href="{{ url('/products/' . $cp->slug) }}">
      <img class="product-compare-section__image" src="{{ RvMedia::getImageUrl($cp->image, 'thumb') }}" alt="{{ $cp->name }}" width="150" height="150" loading="lazy" decoding="async">
      <div class="product-compare-section__name">{{ Str::limit($cp->name, 50) }}</div>
      <div class="product-compare-section__price">฿{{ number_format($cp->price, 0) }}</div>
    </a>
    @endforeach
  </div>
</div>
@endif

{{-- CTA LINE --}}
<div class="product-cta-section mt-4 p-4 text-center">
  <p class="product-cta-section__title">สนใจ {{ $product->name }}? ทักหาเราเลย!</p>
  <div class="product-cta-section__actions">
    <a class="product-cta-section__button product-cta-section__button--line" href="https://page.line.me/rubyshop168?openQrModal=true&utm_source=website&utm_medium=product-page&utm_campaign=product-cta&utm_content={{ $product->slug ?? 'unknown' }}" target="_blank" rel="noopener">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.627-.63h2.386c.349 0 .63.285.63.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.627-.63.349 0 .631.285.631.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.281.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.070 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg>
      ทัก LINE
    </a>
    <a class="product-cta-section__button product-cta-section__button--phone" href="tel:0896667802">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.62 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.09a16 16 0 0 0 6 6l.9-.9a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      089-666-7802
    </a>
  </div>
</div>
