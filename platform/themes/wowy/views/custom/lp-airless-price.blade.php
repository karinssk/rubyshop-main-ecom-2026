@php
    use Botble\Media\Facades\RvMedia;

    $lineUrl = "https://page.line.me/rubyshop168?openQrModal=true&utm_source=website&utm_medium=lp&utm_campaign=airless-price&utm_content=line-cta";
    $contactPhoneDisplay = "089-666-7802";
    $contactPhone = "0896667802";

    $policyLinks = [
        ["label" => "นโยบายความเป็นส่วนตัว", "url" => url("/privacy-policy")],
        ["label" => "เงื่อนไขการใช้บริการ", "url" => url("/terms-of-service")],
        ["label" => "นโยบายการคืนสินค้า", "url" => url("/return-policy")],
    ];

    $priceRanges = [
        ["label" => "งบต่ำกว่า 10,000 บาท", "desc" => "รุ่นพกพา เหมาะงานบ้านเล็ก", "color" => "#22c55e"],
        ["label" => "10,000 – 30,000 บาท", "desc" => "รุ่นกลาง งานบ้าน/รีโนเวท", "color" => "#3b82f6"],
        ["label" => "30,000 – 50,000 บาท", "desc" => "รุ่นมืออาชีพ งานรับเหมา", "color" => "#f59e0b"],
        ["label" => "มากกว่า 50,000 บาท", "desc" => "รุ่นอุตสาหกรรม งานหนัก", "color" => "#dc2626"],
    ];

    $useCases = [
        ["img" => "/storage/lp/use-renovation.jpg", "title" => "ทาสีบ้าน / คอนโด", "desc" => "งบ 10,000-25,000 บาท เลือก RB-360 หรือ RB-B9000 เบา คล่องตัว ใช้ง่าย"],
        ["img" => "/storage/lp/use-construction.jpg", "title" => "งานรับเหมาก่อสร้าง", "desc" => "งบ 25,000-45,000 บาท เลือก RB5300 หรือ RB899 แรงสูง ทนงานหนัก"],
        ["img" => "/storage/lp/use-industrial.jpg", "title" => "งานโรงงาน/อุตสาหกรรม", "desc" => "งบ 80,000+ บาท เลือก RB999S หรือ RB-GM91 สำหรับงานพ่นสีจริงจัง"],
        ["img" => "/storage/lp/use-furniture.jpg", "title" => "งานเฟอร์นิเจอร์/ไม้", "desc" => "งบ 6,000-15,000 บาท เลือก RB-534 หรือ RB-HD-2100 ควบคุมได้ละเอียด"],
    ];
@endphp

<style>
    .ap-wrap { background: #f8fafc; color: #0f172a; }
    .ap-container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
    .ap-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1e293b 100%);
        border-radius: 24px; padding: 52px 40px; color: #fff;
        position: relative; overflow: hidden;
    }
    .ap-hero::before {
        content: ""; position: absolute; top: -60px; right: -60px;
        width: 320px; height: 320px; border-radius: 50%;
        background: rgba(220,38,38,.12);
    }
    .ap-hero-inner { position: relative; z-index: 1; max-width: 720px; }
    .ap-badge {
        display: inline-block; background: rgba(220,38,38,.9); color: #fff;
        padding: 6px 14px; border-radius: 999px; font-size: 12px;
        font-weight: 700; letter-spacing: .07em; text-transform: uppercase; margin-bottom: 14px;
    }
    .ap-h1 { font-size: clamp(28px,4.5vw,52px); line-height: 1.1; font-weight: 800; margin: 0 0 14px; color: #fff; }
    .ap-lead { font-size: clamp(15px,2vw,19px); line-height: 1.6; color: rgba(255,255,255,.88); margin: 0 0 24px; }
    .ap-cta-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .ap-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 13px 22px; font-weight: 700; text-decoration: none; border: 1px solid transparent; font-size: 15px; }
    .ap-btn-primary { background: #dc2626; color: #fff; }
    .ap-btn-primary:hover { background: #b91c1c; color: #fff; }
    .ap-btn-light { background: rgba(255,255,255,.14); color: #fff; border-color: rgba(255,255,255,.35); }
    .ap-btn-light:hover { background: rgba(255,255,255,.22); color: #fff; }
    .ap-section { padding: 32px 0; }
    .ap-section-title { font-size: clamp(22px,3vw,32px); font-weight: 800; margin: 0 0 20px; }
    .ap-price-range-grid { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 12px; margin-bottom: 28px; }
    .ap-price-range-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px; border-top-width: 4px; }
    .ap-price-range-label { font-size: 14px; font-weight: 700; margin: 0 0 4px; }
    .ap-price-range-desc { font-size: 12px; color: #64748b; margin: 0; }
    .ap-product-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 16px; }
    .ap-product-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow .2s; }
    .ap-product-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.1); }
    .ap-product-img { width: 100%; height: 190px; object-fit: contain; background: #fff; }
    .ap-product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .ap-product-name { font-size: 14px; font-weight: 700; margin: 0 0 8px; line-height: 1.4; }
    .ap-product-price { font-size: 22px; font-weight: 800; color: #dc2626; margin: 0 0 12px; }
    .ap-product-cta { margin-top: auto; display: flex; flex-direction: column; gap: 7px; }
    .ap-btn-card-primary { display: block; text-align: center; background: #dc2626; color: #fff; border-radius: 10px; padding: 10px; font-weight: 700; text-decoration: none; font-size: 14px; }
    .ap-btn-card-primary:hover { background: #b91c1c; color: #fff; }
    .ap-btn-card-outline { display: block; text-align: center; background: #f4f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 10px; padding: 9px; font-weight: 600; text-decoration: none; font-size: 14px; }
    .ap-btn-card-outline:hover { border-color: #94a3b8; color: #0f172a; }
    .ap-use-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 14px; }
    .ap-use-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; display: flex; gap: 14px; align-items: flex-start; }
    .ap-use-icon { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; flex-shrink: 0; }
    .ap-use-title { font-size: 16px; font-weight: 700; margin: 0 0 5px; }
    .ap-use-desc { margin: 0; color: #475569; font-size: 14px; line-height: 1.6; }
    .ap-faq { display: grid; gap: 10px; }
    .ap-faq details { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; }
    .ap-faq summary { cursor: pointer; font-weight: 700; font-size: 15px; }
    .ap-faq p { margin: 10px 0 0; color: #475569; line-height: 1.7; font-size: 14px; }
    .ap-cta-band { background: #0f172a; border-radius: 20px; padding: 36px; color: #fff; text-align: center; }
    .ap-cta-band h2 { color: #fff; margin: 0 0 10px; font-size: clamp(22px,3vw,32px); }
    .ap-cta-band p { color: rgba(255,255,255,.82); margin: 0 0 22px; font-size: 16px; }
    .ap-cta-band .ap-cta-row { justify-content: center; }
    .ap-footer { margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 16px; color: #64748b; font-size: 13px; }
    .ap-policy-links { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 8px; }
    .ap-policy-links a { color: #334155; text-decoration: none; }
    .ap-policy-links a:hover { color: #dc2626; }
    .ap-sticky { position: fixed; left: 0; right: 0; bottom: 0; z-index: 70; background: rgba(15,23,42,.96); backdrop-filter: blur(6px); border-top: 1px solid rgba(148,163,184,.3); padding: 10px 12px; display: none; }
    .ap-sticky-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .ap-sticky a { text-align: center; text-decoration: none; padding: 11px 10px; border-radius: 999px; font-weight: 700; }
    .ap-sticky-call { background: #f4f5f9; color: #0f172a; }
    .ap-sticky-line { background: #dc2626; color: #fff; }
    @media (max-width: 980px) { .ap-price-range-grid { grid-template-columns: 1fr 1fr; } .ap-product-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 720px) { .ap-hero { padding: 32px 20px; } .ap-product-grid { grid-template-columns: 1fr; } .ap-use-grid { grid-template-columns: 1fr; } .ap-price-range-grid { grid-template-columns: 1fr 1fr; } .ap-sticky { display: block; } .ap-wrap { padding-bottom: 84px; } }
</style>

<div class="ap-wrap">
    <!-- Quick Nav -->
    <style>
    .lp-quicknav { background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:10px 0; font-size:13px; }
    .lp-quicknav-inner { width:min(1180px,calc(100% - 32px)); margin:0 auto; display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
    .lp-quicknav-label { color:#64748b; font-weight:600; margin-right:4px; }
    .lp-quicknav a { padding:4px 14px; border-radius:999px; background:#fff; border:1px solid #cbd5e1; color:#0f172a; text-decoration:none; white-space:nowrap; transition:all .2s ease; display:inline-block; }
    .lp-quicknav a:hover { background:#b40c00; border-color:#b40c00; color:#fff; transform:translateY(-1px); box-shadow:0 2px 8px rgba(180,12,0,.25); }
    </style>
    <div class="lp-quicknav">
        <div class="lp-quicknav-inner">
            <span class="lp-quicknav-label">คู่มือเลือกซื้อ:</span>
            <a href="/lp/airless-sprayer-thailand">Airless Hub</a>
            <a href="/lp/airless-sprayer-price">เปรียบเทียบราคา</a>
            <a href="/lp/airless-spray-gun">ปืนพ่นสี</a>
            <a href="/lp/airless-hose">สายพ่นสี</a>
            <a href="/lp/drywall-sander">เครื่องขัดผนัง</a>
            <a href="/lp/wall-chaser">เครื่องกรีดผนัง</a>
        </div>
    </div>

    <div class="ap-container" style="padding: 24px 0 8px;">

        {{-- Hero --}}
        <section class="ap-hero">
            <div class="ap-hero-inner">
                <div class="ap-badge">ราคาเครื่องพ่นสีแรงดันสูง</div>
                <h1 class="ap-h1">ราคาเครื่องพ่นสีแรงดันสูง<br>เปรียบเทียบทุกรุ่น RubyShop</h1>
                <p class="ap-lead">รวมราคาเครื่องพ่นสีแรงดันสูง (Airless Sprayer) ทุกรุ่น ตั้งแต่หมื่นต้นถึงอุตสาหกรรม เลือกให้ตรงงบและประเภทงาน</p>
                <div class="ap-cta-row">
                    <a class="ap-btn ap-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ขอคำแนะนำ</a>
                    <a class="ap-btn ap-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Price Range Guide --}}
        <section class="ap-section">
            <h2 class="ap-section-title">เลือกราคาให้ตรงงบและประเภทงาน</h2>
            <div class="ap-price-range-grid">
                @foreach ($priceRanges as $pr)
                    <div class="ap-price-range-card" style="border-top-color: {{ $pr['color'] }}">
                        <div class="ap-price-range-label">{{ $pr['label'] }}</div>
                        <p class="ap-price-range-desc">{{ $pr['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Products --}}
        <section class="ap-section">
            <h2 class="ap-section-title">เปรียบเทียบราคาเครื่องพ่นสีแรงดันสูงทุกรุ่น</h2>
            <div class="ap-product-grid">
                @foreach ($products as $p)
                    <div class="ap-product-card">
                        @if ($p["image"])
                            <img class="ap-product-img" src="{{ RvMedia::getImageUrl($p["image"], "origin", false, RvMedia::getDefaultImage()) }}" alt="{{ $p["name"] }}" loading="lazy">
                        @else
                            <div class="ap-product-img" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px;">ไม่มีรูป</div>
                        @endif
                        <div class="ap-product-body">
                            <div class="ap-product-name">{{ $p["name"] }}</div>
                            <div class="ap-product-price">฿{{ $p["price"] }}</div>
                            <div class="ap-product-cta">
                                <a class="ap-btn-card-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">สอบถาม / สั่งซื้อ LINE</a>
                                <a class="ap-btn-card-outline" href="{{ $p["url"] }}">ดูรายละเอียดสินค้า</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Use Cases --}}
        <section class="ap-section">
            <h2 class="ap-section-title">เหมาะกับงานแบบไหน งบเท่าไร?</h2>
            <div class="ap-use-grid">
                @foreach ($useCases as $uc)
                    <div class="ap-use-card">
                        <img class="ap-use-icon" src="{{ $uc['img'] }}" alt="{{ $uc['title'] }}" loading="lazy">
                        <div>
                            <div class="ap-use-title">{{ $uc["title"] }}</div>
                            <p class="ap-use-desc">{{ $uc["desc"] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- FAQ --}}
        <section class="ap-section">
            <h2 class="ap-section-title">คำถามที่พบบ่อย เรื่องราคาเครื่องพ่นสีแรงดันสูง</h2>
            <div class="ap-faq">
                @foreach ($faqItems as $faq)
                    <details>
                        <summary>{{ $faq["q"] }}</summary>
                        <p>{{ $faq["a"] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        {{-- CTA Band --}}
        <section class="ap-section">
            <div class="ap-cta-band">
                <h2>ไม่แน่ใจว่างบเท่าไรควรเลือกรุ่นไหน?</h2>
                <p>ปรึกษาทีม RubyShop ฟรี บอกประเภทงานและงบประมาณ เราแนะนำรุ่นให้เหมาะสม ไม่ขายเกินความต้องการ</p>
                <div class="ap-cta-row">
                    <a class="ap-btn ap-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ฟรี</a>
                    <a class="ap-btn ap-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <div class="ap-footer">
            <div>© {{ date("Y") }} RubyShop Co., Ltd.</div>
            <div class="ap-policy-links">
                @foreach ($policyLinks as $policy)
                    <a href="{{ $policy["url"] }}">{{ $policy["label"] }}</a>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Sticky mobile bar --}}
<div class="ap-sticky">
    <div class="ap-sticky-row">
        <a class="ap-sticky-call" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
        <a class="ap-sticky-line" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE</a>
    </div>
</div>

{{-- JSON-LD Schema --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {"@type":"ListItem","position":1,"name":"หน้าแรก","item":"https://www.rubyshop.co.th"},
        {"@type":"ListItem","position":2,"name":"เครื่องพ่นสีแรงดันสูง","item":"https://www.rubyshop.co.th/lp/airless-sprayer-thailand"},
        {"@type":"ListItem","position":3,"name":"ราคาเครื่องพ่นสีแรงดันสูง","item":"https://www.rubyshop.co.th/lp/airless-sprayer-price"}
      ]
    },
    {
      "@type": "FAQPage",
      "mainEntity": [
        @foreach($faqItems as $faq)
        {
          "@type": "Question",
          "name": "{{ $faq["q"] }}",
          "acceptedAnswer": {"@type": "Answer", "text": "{{ $faq["a"] }}"}
        }{{ !$loop->last ? "," : "" }}
        @endforeach
      ]
    },
    {
      "@type": "ItemList",
      "name": "ราคาเครื่องพ่นสีแรงดันสูง RubyShop",
      "itemListElement": [
        @foreach($products as $i => $p)
        {
          "@type": "ListItem",
          "position": {{ $i + 1 }},
          "item": {
            "@type": "Product",
            "name": "{{ $p["name"] }}",
            "url": "{{ $p["url"] }}",
            "offers": {"@type": "Offer", "price": "{{ $p["price_raw"] }}", "priceCurrency": "THB", "availability": "https://schema.org/InStock"}
          }
        }{{ !$loop->last ? "," : "" }}
        @endforeach
      ]
    }
  ]
}
</script>
