@php
    use Botble\Media\Facades\RvMedia;

    $lineUrl = "https://page.line.me/rubyshop168?openQrModal=true&utm_source=website&utm_medium=lp&utm_campaign=spray-gun&utm_content=line-cta";
    $contactPhoneDisplay = "089-666-7802";
    $contactPhone = "0896667802";

    $policyLinks = [
        ["label" => "นโยบายความเป็นส่วนตัว", "url" => url("/privacy-policy")],
        ["label" => "เงื่อนไขการใช้บริการ", "url" => url("/terms-of-service")],
        ["label" => "นโยบายการคืนสินค้า", "url" => url("/return-policy")],
    ];

    $useCases = [
        ["img" => "/storage/lp/sg-house.jpg", "title" => "งานพ่นสีบ้านและอาคาร", "desc" => "พ่นสีทาบ้านได้รวดเร็ว เนียนสม่ำเสมอ ครอบคลุมพื้นที่กว้าง ลดเวลาและแรงงานเทียบกับการทาด้วยแปรง"],
        ["img" => "/storage/lp/sg-skimcoat.jpg", "title" => "งานฉาบสกิมโค้ท", "desc" => "ปืนพ่นสกิมโค้ท RubyShop รองรับสีหนืดและปูนฉาบ ให้ผิวงานเนียนสม่ำเสมอ ประหยัดเวลาฉาบ"],
        ["img" => "/storage/lp/sg-cement.jpg", "title" => "งานพ่นปูนซีเมนต์", "desc" => "Airless Sprayer แรงดันสูงพ่นปูนซีเมนต์และสารเคลือบได้ดี เหมาะกับงานรับเหมาขนาดใหญ่"],
        ["img" => "/storage/lp/sg-industrial.jpg", "title" => "งานพ่นสีอุตสาหกรรม", "desc" => "ปืนพ่นสี Airless รองรับสีอีพ็อกซี่และสีพิเศษ ใช้ในโรงงาน โกดัง และงานอุตสาหกรรมทุกประเภท"],
    ];

    $highlights = [
        ["title" => "ปืนพ่นสีทุกรุ่น มีอะไหล่พร้อม", "desc" => "RubyShop มีอะไหล่ทดแทนสำหรับทุกรุ่น ไม่ต้องรอนำเข้า บริการซ่อมรวดเร็ว"],
        ["title" => "filter ทุกขนาด (30, 60, 100 mesh)", "desc" => "มี filter สีทุกขนาดพร้อมจำหน่าย เปลี่ยนง่าย รักษาแรงดันให้คงที่ตลอดการใช้งาน"],
        ["title" => "รับประกันจากศูนย์", "desc" => "สินค้าทุกชิ้นรับประกันจากศูนย์ มีใบรับประกัน ทีมช่างเทคนิคพร้อมให้คำปรึกษา"],
        ["title" => "ส่งไวทั่วไทย", "desc" => "สินค้าพร้อมส่ง จัดส่ง 1-3 วันทำการทั่วประเทศ หรือรับสินค้าที่ร้านได้เลย"],
        ["title" => "ปรึกษาฟรีก่อนสั่งซื้อ", "desc" => "ทีม RubyShop พร้อมแนะนำรุ่นที่เหมาะกับงานของคุณ บอกประเภทสีและพื้นที่ เราช่วยเลือกให้"],
        ["title" => "ราคาดี ตรงจากผู้นำเข้า", "desc" => "RubyShop นำเข้าตรง ไม่ผ่านคนกลาง ราคาย่อมเยา มั่นใจได้ทั้งคุณภาพและบริการหลังการขาย"],
    ];
@endphp

<style>
    .sg-wrap { background: #f8fafc; color: #0f172a; }
    .sg-container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
    .sg-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1e293b 100%);
        border-radius: 24px; padding: 52px 40px; color: #fff;
        position: relative; overflow: hidden;
    }
    .sg-hero::before {
        content: ""; position: absolute; top: -60px; right: -60px;
        width: 320px; height: 320px; border-radius: 50%;
        background: rgba(59,130,246,.15);
    }
    .sg-hero-inner { position: relative; z-index: 1; max-width: 720px; }
    .sg-badge {
        display: inline-block; background: rgba(59,130,246,.85); color: #fff;
        padding: 6px 14px; border-radius: 999px; font-size: 12px;
        font-weight: 700; letter-spacing: .07em; text-transform: uppercase; margin-bottom: 14px;
    }
    .sg-h1 { font-size: clamp(28px,4.5vw,52px); line-height: 1.1; font-weight: 800; margin: 0 0 14px; color: #fff; }
    .sg-lead { font-size: clamp(15px,2vw,19px); line-height: 1.6; color: rgba(255,255,255,.88); margin: 0 0 24px; }
    .sg-cta-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .sg-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 13px 22px; font-weight: 700; text-decoration: none; border: 1px solid transparent; font-size: 15px; }
    .sg-btn-primary { background: #b40c00; color: #fff; }
    .sg-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .sg-btn-light { background: rgba(255,255,255,.14); color: #fff; border-color: rgba(255,255,255,.35); }
    .sg-btn-light:hover { background: rgba(255,255,255,.22); color: #fff; }
    .sg-section { padding: 32px 0; }
    .sg-section-title { font-size: clamp(22px,3vw,32px); font-weight: 800; margin: 0 0 20px; }
    .sg-product-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 16px; }
    .sg-product-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow .2s; }
    .sg-product-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.1); }
    .sg-product-card.featured { border-color: #2563eb; border-width: 2px; }
    .sg-product-img { width: 100%; height: 190px; object-fit: contain; background: #fff; }
    .sg-product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .sg-product-name { font-size: 14px; font-weight: 700; margin: 0 0 8px; line-height: 1.4; }
    .sg-product-price { font-size: 22px; font-weight: 800; color: #2563eb; margin: 0 0 12px; }
    .sg-product-cta { margin-top: auto; display: flex; flex-direction: column; gap: 7px; }
    .sg-btn-card-primary { display: block; text-align: center; background: #b40c00; color: #fff; border-radius: 10px; padding: 10px; font-weight: 700; text-decoration: none; font-size: 14px; }
    .sg-btn-card-primary:hover { background: #1d4ed8; color: #fff; }
    .sg-btn-card-outline { display: block; text-align: center; background: #f4f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 10px; padding: 9px; font-weight: 600; text-decoration: none; font-size: 14px; }
    .sg-btn-card-outline:hover { border-color: #94a3b8; color: #0f172a; }
    .sg-use-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 14px; }
    .sg-use-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; display: flex; gap: 14px; align-items: flex-start; }
    .sg-use-icon { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; flex-shrink: 0; }
    .sg-use-title { font-size: 16px; font-weight: 700; margin: 0 0 5px; }
    .sg-use-desc { margin: 0; color: #475569; font-size: 14px; line-height: 1.6; }
    .sg-highlight-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 12px; }
    .sg-highlight-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; }
    .sg-highlight-card h3 { font-size: 15px; font-weight: 700; margin: 0 0 6px; }
    .sg-highlight-card p { margin: 0; color: #475569; font-size: 13px; line-height: 1.6; }
    .sg-faq { display: grid; gap: 10px; }
    .sg-faq details { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; }
    .sg-faq summary { cursor: pointer; font-weight: 700; font-size: 15px; }
    .sg-faq p { margin: 10px 0 0; color: #475569; line-height: 1.7; font-size: 14px; }
    .sg-cta-band { background: #0f172a; border-radius: 20px; padding: 36px; color: #fff; text-align: center; }
    .sg-cta-band h2 { color: #fff; margin: 0 0 10px; font-size: clamp(22px,3vw,32px); }
    .sg-cta-band p { color: rgba(255,255,255,.82); margin: 0 0 22px; font-size: 16px; }
    .sg-cta-band .sg-cta-row { justify-content: center; }
    .sg-footer { margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 16px; color: #64748b; font-size: 13px; }
    .sg-policy-links { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 8px; }
    .sg-policy-links a { color: #334155; text-decoration: none; }
    .sg-policy-links a:hover { color: #2563eb; }
    .sg-sticky { position: fixed; left: 0; right: 0; bottom: 0; z-index: 70; background: rgba(15,23,42,.96); backdrop-filter: blur(6px); border-top: 1px solid rgba(148,163,184,.3); padding: 10px 12px; display: none; }
    .sg-sticky-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .sg-sticky a { text-align: center; text-decoration: none; padding: 11px 10px; border-radius: 999px; font-weight: 700; }
    .sg-sticky-call { background: #f4f5f9; color: #0f172a; }
    .sg-sticky-line { background: #b40c00; color: #fff; }
    @media (max-width: 980px) { .sg-product-grid { grid-template-columns: 1fr 1fr; } .sg-highlight-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 720px) { .sg-hero { padding: 32px 20px; } .sg-product-grid { grid-template-columns: 1fr; } .sg-use-grid { grid-template-columns: 1fr; } .sg-highlight-grid { grid-template-columns: 1fr; } .sg-sticky { display: block; } .sg-wrap { padding-bottom: 84px; } }
</style>

<div class="sg-wrap">
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

    <div class="sg-container" style="padding: 24px 0 8px;">

        {{-- Hero --}}
        <section class="sg-hero">
            <div class="sg-hero-inner">
                <div class="sg-badge">Airless Spray Gun Hub</div>
                <h1 class="sg-h1">ปืนพ่นสี Airless ทุกรุ่น RubyShop</h1>
                <p class="sg-lead">เปรียบเทียบปืนพ่นสี Airless ทุกรุ่น สำหรับงานพ่นสี สกิมโค้ท ปูนซีเมนต์ เลือกให้เหมาะกับงานของคุณ</p>
                <div class="sg-cta-row">
                    <a class="sg-btn sg-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ขอคำแนะนำ</a>
                    <a class="sg-btn sg-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Products --}}
        <section class="sg-section">
            <h2 class="sg-section-title">เปรียบเทียบปืนพ่นสี Airless RubyShop ทุกรุ่น</h2>
            <div class="sg-product-grid">
                @foreach ($products as $idx => $p)
                    <div class="sg-product-card{{ $idx === 0 ? " featured" : "" }}">
                        @if ($p["image"])
                            <img class="sg-product-img" src="{{ RvMedia::getImageUrl($p["image"], "origin", false, RvMedia::getDefaultImage()) }}" alt="{{ $p["name"] }}" loading="lazy">
                        @else
                            <div class="sg-product-img" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px;">ไม่มีรูป</div>
                        @endif
                        <div class="sg-product-body">
                            <div class="sg-product-name">{{ $p["name"] }}</div>
                            <div class="sg-product-price">฿{{ $p["price"] }}</div>
                            <div class="sg-product-cta">
                                <a class="sg-btn-card-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">สอบถาม / สั่งซื้อ LINE</a>
                                <a class="sg-btn-card-outline" href="{{ $p["url"] }}">ดูรายละเอียดสินค้า</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Use Cases --}}
        <section class="sg-section">
            <h2 class="sg-section-title">เหมาะกับงานแบบไหน?</h2>
            <div class="sg-use-grid">
                @foreach ($useCases as $uc)
                    <div class="sg-use-card">
                        <img class="sg-use-icon" src="{{ $uc['img'] }}" alt="{{ $uc['title'] }}" loading="lazy">
                        <div>
                            <div class="sg-use-title">{{ $uc["title"] }}</div>
                            <p class="sg-use-desc">{{ $uc["desc"] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Highlights --}}
        <section class="sg-section">
            <h2 class="sg-section-title">จุดเด่นปืนพ่นสี Airless RubyShop</h2>
            <div class="sg-highlight-grid">
                @foreach ($highlights as $h)
                    <div class="sg-highlight-card">
                        <h3>{{ $h["title"] }}</h3>
                        <p>{{ $h["desc"] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- FAQ --}}
        <section class="sg-section">
            <h2 class="sg-section-title">คำถามที่พบบ่อย ปืนพ่นสี Airless</h2>
            <div class="sg-faq">
                @foreach ($faqItems as $faq)
                    <details>
                        <summary>{{ $faq["q"] }}</summary>
                        <p>{{ $faq["a"] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        {{-- CTA Band --}}
        <section class="sg-section">
            <div class="sg-cta-band">
                <h2>ไม่แน่ใจว่ารุ่นไหนเหมาะกับงานคุณ?</h2>
                <p>ปรึกษาทีม RubyShop ฟรี บอกประเภทสีและพื้นที่งาน เราแนะนำปืนพ่นสีให้ตรงจุด</p>
                <div class="sg-cta-row">
                    <a class="sg-btn sg-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ฟรี</a>
                    <a class="sg-btn sg-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <div class="sg-footer">
            <div>© {{ date("Y") }} RubyShop Co., Ltd.</div>
            <div class="sg-policy-links">
                @foreach ($policyLinks as $policy)
                    <a href="{{ $policy["url"] }}">{{ $policy["label"] }}</a>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Sticky mobile bar --}}
<div class="sg-sticky">
    <div class="sg-sticky-row">
        <a class="sg-sticky-call" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
        <a class="sg-sticky-line" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE</a>
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
        {"@type":"ListItem","position":2,"name":"ปืนพ่นสี Airless","item":"https://www.rubyshop.co.th/lp/airless-spray-gun"}
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
      "name": "ปืนพ่นสี Airless RubyShop",
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
