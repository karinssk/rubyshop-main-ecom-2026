@php
    use Botble\Media\Facades\RvMedia;

    $lineUrl = "https://page.line.me/rubyshop168?openQrModal=true&utm_source=website&utm_medium=lp&utm_campaign=wall-chaser&utm_content=line-cta";
    $contactPhoneDisplay = "089-666-7802";
    $contactPhone = "0896667802";

    $policyLinks = [
        ["label" => "นโยบายความเป็นส่วนตัว", "url" => url("/privacy-policy")],
        ["label" => "เงื่อนไขการใช้บริการ", "url" => url("/terms-of-service")],
        ["label" => "นโยบายการคืนสินค้า", "url" => url("/return-policy")],
    ];

    $useCases = [
        ["icon" => "⚡", "title" => "วางท่อสายไฟในผนัง", "desc" => "กรีดร่องฝังสายไฟ ได้ร่องแม่นยำ ผนังสะอาด ไม่ต้องทุบผนังทั้งแผ่น ลดค่าซ่อมแซมได้มาก"],
        ["icon" => "💧", "title" => "วางท่อน้ำและท่อแอร์", "desc" => "กรีดร่องเพื่อฝังท่อน้ำ ท่อแอร์ หรือท่อสื่อสาร ทั้งผนังอิฐมวลเบาและคอนกรีต"],
        ["icon" => "🏗️", "title" => "งานรับเหมาก่อสร้าง", "desc" => "เพิ่มความเร็วงานเดินสาย รุ่นกำลังสูงอย่าง WALLCD-100A และ RB-1009 รองรับงานหนักต่อเนื่อง"],
        ["icon" => "🏠", "title" => "งานรีโนเวทบ้าน", "desc" => "รุ่นกำลังกลาง WALLCD-2005/2006 ราคาย่อมเยา เหมาะกับงานบ้านและคอนโดที่ต้องการเพิ่มสายไฟหรือท่อใหม่"],
    ];

    $highlights = [
        ["title" => "ระบบน้ำ ไร้ฝุ่น", "desc" => "หลายรุ่นมีระบบน้ำดักจับฝุ่น ทำงานสะอาด เหมาะกับงานในอาคารที่มีคนอยู่"],
        ["title" => "ครบทุกกำลังวัตต์", "desc" => "มีตั้งแต่ 1,100W ถึง 4,800W ให้เลือกตามความต้องการของงาน"],
        ["title" => "กรีดได้ทั้งอิฐมวลเบาและคอนกรีต", "desc" => "บางรุ่นออกแบบมาสำหรับอิฐมวลเบา บางรุ่นรองรับคอนกรีตได้ด้วย"],
        ["title" => "อะไหล่ใบตัดพร้อมส่ง", "desc" => "มีใบตัดและอะไหล่ทุกรุ่น จัดส่งทั่วประเทศ ไม่ต้องรอนำเข้า"],
        ["title" => "ปรึกษาก่อนเลือกรุ่น", "desc" => "ทีมงาน RubyShop แนะนำรุ่นให้ตรงกับประเภทผนัง ขนาดท่อ และปริมาณงาน"],
        ["title" => "ส่งไวทั่วไทย", "desc" => "สินค้าพร้อมส่ง 1-3 วันทำการ หรือรับที่ร้านได้เลย"],
    ];
@endphp

<style>
    .wc-wrap { background: #f8fafc; color: #0f172a; }
    .wc-container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
    .wc-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e2a4a 60%, #1e293b 100%);
        border-radius: 24px; padding: 52px 40px; color: #fff;
        position: relative; overflow: hidden;
    }
    .wc-hero::before {
        content: ""; position: absolute; top: -60px; right: -60px;
        width: 320px; height: 320px; border-radius: 50%;
        background: rgba(59,130,246,.12);
    }
    .wc-hero-inner { position: relative; z-index: 1; max-width: 720px; }
    .wc-badge {
        display: inline-block; background: rgba(59,130,246,.9); color: #fff;
        padding: 6px 14px; border-radius: 999px; font-size: 12px;
        font-weight: 700; letter-spacing: .07em; text-transform: uppercase; margin-bottom: 14px;
    }
    .wc-h1 { font-size: clamp(28px,4.5vw,52px); line-height: 1.1; font-weight: 800; margin: 0 0 14px; color: #fff; }
    .wc-lead { font-size: clamp(15px,2vw,19px); line-height: 1.6; color: rgba(255,255,255,.88); margin: 0 0 24px; }
    .wc-cta-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .wc-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 13px 22px; font-weight: 700; text-decoration: none; border: 1px solid transparent; font-size: 15px; }
    .wc-btn-primary { background: #b40c00; color: #fff; }
    .wc-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .wc-btn-light { background: rgba(255,255,255,.14); color: #fff; border-color: rgba(255,255,255,.35); }
    .wc-btn-light:hover { background: rgba(255,255,255,.22); color: #fff; }
    .wc-section { padding: 32px 0; }
    .wc-section-title { font-size: clamp(22px,3vw,32px); font-weight: 800; margin: 0 0 20px; }
    .wc-product-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 16px; }
    .wc-product-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow .2s; }
    .wc-product-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.1); }
    .wc-product-card.featured { border-color: #2563eb; border-width: 2px; }
    .wc-product-img { width: 100%; height: 190px; object-fit: contain; background: #fff; }
    .wc-product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .wc-product-name { font-size: 14px; font-weight: 700; margin: 0 0 8px; line-height: 1.4; }
    .wc-product-price { font-size: 22px; font-weight: 800; color: #2563eb; margin: 0 0 12px; }
    .wc-product-cta { margin-top: auto; display: flex; flex-direction: column; gap: 7px; }
    .wc-btn-card-primary { display: block; text-align: center; background: #b40c00; color: #fff; border-radius: 10px; padding: 10px; font-weight: 700; text-decoration: none; font-size: 14px; }
    .wc-btn-card-primary:hover { background: #1d4ed8; color: #fff; }
    .wc-btn-card-outline { display: block; text-align: center; background: #f4f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 10px; padding: 9px; font-weight: 600; text-decoration: none; font-size: 14px; }
    .wc-btn-card-outline:hover { border-color: #94a3b8; color: #0f172a; }
    .wc-use-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 14px; }
    .wc-use-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; display: flex; gap: 14px; align-items: flex-start; }
    .wc-use-icon { font-size: 28px; flex-shrink: 0; }
    .wc-use-title { font-size: 16px; font-weight: 700; margin: 0 0 5px; }
    .wc-use-desc { margin: 0; color: #475569; font-size: 14px; line-height: 1.6; }
    .wc-highlight-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 12px; }
    .wc-highlight-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; }
    .wc-highlight-card h3 { font-size: 15px; font-weight: 700; margin: 0 0 6px; }
    .wc-highlight-card p { margin: 0; color: #475569; font-size: 13px; line-height: 1.6; }
    .wc-faq { display: grid; gap: 10px; }
    .wc-faq details { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; }
    .wc-faq summary { cursor: pointer; font-weight: 700; font-size: 15px; }
    .wc-faq p { margin: 10px 0 0; color: #475569; line-height: 1.7; font-size: 14px; }
    .wc-cta-band { background: #0f172a; border-radius: 20px; padding: 36px; color: #fff; text-align: center; }
    .wc-cta-band h2 { color: #fff; margin: 0 0 10px; font-size: clamp(22px,3vw,32px); }
    .wc-cta-band p { color: rgba(255,255,255,.82); margin: 0 0 22px; font-size: 16px; }
    .wc-cta-band .wc-cta-row { justify-content: center; }
    .wc-footer { margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 16px; color: #64748b; font-size: 13px; }
    .wc-policy-links { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 8px; }
    .wc-policy-links a { color: #334155; text-decoration: none; }
    .wc-policy-links a:hover { color: #2563eb; }
    .wc-sticky { position: fixed; left: 0; right: 0; bottom: 0; z-index: 70; background: rgba(15,23,42,.96); backdrop-filter: blur(6px); border-top: 1px solid rgba(148,163,184,.3); padding: 10px 12px; display: none; }
    .wc-sticky-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .wc-sticky a { text-align: center; text-decoration: none; padding: 11px 10px; border-radius: 999px; font-weight: 700; }
    .wc-sticky-call { background: #f4f5f9; color: #0f172a; }
    .wc-sticky-line { background: #b40c00; color: #fff; }
    @media (max-width: 980px) { .wc-product-grid { grid-template-columns: 1fr 1fr; } .wc-highlight-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 720px) { .wc-hero { padding: 32px 20px; } .wc-product-grid { grid-template-columns: 1fr; } .wc-use-grid { grid-template-columns: 1fr; } .wc-highlight-grid { grid-template-columns: 1fr; } .wc-sticky { display: block; } .wc-wrap { padding-bottom: 84px; } }
</style>

<div class="wc-wrap">
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

    <div class="wc-container" style="padding: 24px 0 8px;">

        {{-- Hero --}}
        <section class="wc-hero">
            <div class="wc-hero-inner">
                <div class="wc-badge">Wall Chaser Hub</div>
                <h1 class="wc-h1">เครื่องกรีดผนัง เซาะร่อง<br>ทุกรุ่น RubyShop</h1>
                <p class="wc-lead">เปรียบเทียบเครื่องกรีดผนัง (Wall Chaser) WALLCD ทุกรุ่น ระบบน้ำ ไร้ฝุ่น วางท่อสายไฟ ท่อน้ำ กรีดผนังอิฐมวลเบาและคอนกรีต</p>
                <div class="wc-cta-row">
                    <a class="wc-btn wc-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ขอคำแนะนำ</a>
                    <a class="wc-btn wc-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Products --}}
        <section class="wc-section">
            <h2 class="wc-section-title">เปรียบเทียบเครื่องกรีดผนัง RubyShop ทุกรุ่น</h2>
            <div class="wc-product-grid">
                @foreach ($products as $idx => $p)
                    <div class="wc-product-card{{ $idx === 0 ? " featured" : "" }}">
                        @if ($p["image"])
                            <img class="wc-product-img" src="{{ RvMedia::getImageUrl($p["image"], "origin", false, RvMedia::getDefaultImage()) }}" alt="{{ $p["name"] }}" loading="lazy">
                        @else
                            <div class="wc-product-img" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px;">ไม่มีรูป</div>
                        @endif
                        <div class="wc-product-body">
                            <div class="wc-product-name">{{ $p["name"] }}</div>
                            <div class="wc-product-price">฿{{ $p["price"] }}</div>
                            <div class="wc-product-cta">
                                <a class="wc-btn-card-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">สอบถาม / สั่งซื้อ LINE</a>
                                <a class="wc-btn-card-outline" href="{{ $p["url"] }}">ดูรายละเอียดสินค้า</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Use Cases --}}
        <section class="wc-section">
            <h2 class="wc-section-title">เหมาะกับงานแบบไหน?</h2>
            <div class="wc-use-grid">
                @foreach ($useCases as $uc)
                    <div class="wc-use-card">
                        <div class="wc-use-icon">{{ $uc["icon"] }}</div>
                        <div>
                            <div class="wc-use-title">{{ $uc["title"] }}</div>
                            <p class="wc-use-desc">{{ $uc["desc"] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Highlights --}}
        <section class="wc-section">
            <h2 class="wc-section-title">จุดเด่นเครื่องกรีดผนัง RubyShop</h2>
            <div class="wc-highlight-grid">
                @foreach ($highlights as $h)
                    <div class="wc-highlight-card">
                        <h3>{{ $h["title"] }}</h3>
                        <p>{{ $h["desc"] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- FAQ --}}
        <section class="wc-section">
            <h2 class="wc-section-title">คำถามที่พบบ่อย เครื่องกรีดผนัง เซาะร่อง</h2>
            <div class="wc-faq">
                @foreach ($faqItems as $faq)
                    <details>
                        <summary>{{ $faq["q"] }}</summary>
                        <p>{{ $faq["a"] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        {{-- CTA Band --}}
        <section class="wc-section">
            <div class="wc-cta-band">
                <h2>ไม่แน่ใจว่ารุ่นไหนเหมาะกับผนังประเภทไหน?</h2>
                <p>ปรึกษาทีม RubyShop ฟรี บอกประเภทผนัง ขนาดท่อที่ต้องการฝัง เราแนะนำรุ่นให้ตรงจุด</p>
                <div class="wc-cta-row">
                    <a class="wc-btn wc-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ฟรี</a>
                    <a class="wc-btn wc-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <div class="wc-footer">
            <div>© {{ date("Y") }} RubyShop Co., Ltd.</div>
            <div class="wc-policy-links">
                @foreach ($policyLinks as $policy)
                    <a href="{{ $policy["url"] }}">{{ $policy["label"] }}</a>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Sticky mobile bar --}}
<div class="wc-sticky">
    <div class="wc-sticky-row">
        <a class="wc-sticky-call" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
        <a class="wc-sticky-line" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE</a>
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
        {"@type":"ListItem","position":2,"name":"เครื่องกรีดผนัง","item":"https://www.rubyshop.co.th/lp/wall-chaser"}
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
      "name": "เครื่องกรีดผนัง RubyShop",
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
