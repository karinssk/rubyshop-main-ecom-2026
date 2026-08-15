@php
    use Botble\Media\Facades\RvMedia;

    $lineUrl = "https://page.line.me/rubyshop168?openQrModal=true&utm_source=website&utm_medium=lp&utm_campaign=airless-hose&utm_content=line-cta";
    $contactPhoneDisplay = "089-666-7802";
    $contactPhone = "0896667802";

    $policyLinks = [
        ["label" => "นโยบายความเป็นส่วนตัว", "url" => url("/privacy-policy")],
        ["label" => "เงื่อนไขการใช้บริการ", "url" => url("/terms-of-service")],
        ["label" => "นโยบายการคืนสินค้า", "url" => url("/return-policy")],
    ];

    $useCases = [
        ["icon" => "🏢", "title" => "งานพ่นสีภายนอกอาคาร (สาย 15m)", "desc" => "สาย 15m ช่วยลดการเคลื่อนย้ายเครื่อง ครอบคลุมพื้นที่กว้าง เหมาะกับงานพ่นสีตึกอาคารหลายชั้นและงานรับเหมาขนาดใหญ่"],
        ["icon" => "🏠", "title" => "งานพ่นสีภายใน (สาย 5-10m)", "desc" => "สาย 5-10m น้ำหนักเบา คล่องตัวสูง เหมาะกับงานพ่นสีภายในบ้านและอาคาร งานห้องพักและพื้นที่จำกัด"],
        ["icon" => "🔩", "title" => "งานพ่นปูนและสกิมโค้ท (HOSE Mortar)", "desc" => "สายขนาด 3/8 นิ้ว รองรับสารผ่านสูง เหมาะกับการพ่นปูนซีเมนต์ สกิมโค้ท และวัสดุหนืดผ่านเครื่องพ่น Airless"],
        ["icon" => "🛠️", "title" => "งานขัดผนัง (Extend tube)", "desc" => "Extend tube และ Connector อุปกรณ์เสริมที่ขาดไม่ได้ ต่อขยายระยะพ่น เข้าถึงพื้นที่สูงและมุมยากได้สะดวก"],
    ];

    $highlights = [
        ["title" => "สาย 5m / 10m / 15m พร้อมส่ง", "desc" => "มีสต็อกทุกขนาดพร้อมส่งทันที ไม่ต้องรอ จัดส่ง 1-3 วันทำการทั่วประเทศ"],
        ["title" => "ขนาด 1/4 และ 3/8 นิ้ว", "desc" => "ครบทุกขนาดมาตรฐาน เลือกให้เหมาะกับเครื่องพ่นสีและประเภทงาน"],
        ["title" => "ทนแรงดันสูงถึง 3,600 PSI", "desc" => "วัสดุคุณภาพสูง ทนแรงดันสูง ใช้งานได้นาน ปลอดภัยแม้งานหนัก"],
        ["title" => "ข้อต่อมาตรฐาน Universal", "desc" => "ข้อต่อ Universal ใช้ร่วมกับเครื่องพ่นสี Airless ทั่วไปได้ ติดตั้งง่าย ไม่รั่วซึม"],
        ["title" => "อะไหล่ครบ", "desc" => "RubyShop มีอะไหล่ข้อต่อ Connector Suction และอุปกรณ์เสริมครบ ไม่ต้องหาที่อื่น"],
        ["title" => "ส่งไวทั่วไทย", "desc" => "พร้อมส่งทุกวัน จัดส่งรวดเร็วทั่วประเทศ หรือรับสินค้าที่ร้านได้เลย"],
    ];
@endphp

<style>
    .ah-wrap { background: #f8fafc; color: #0f172a; }
    .ah-container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
    .ah-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1e293b 100%);
        border-radius: 24px; padding: 52px 40px; color: #fff;
        position: relative; overflow: hidden;
    }
    .ah-hero::before {
        content: ""; position: absolute; top: -60px; right: -60px;
        width: 320px; height: 320px; border-radius: 50%;
        background: rgba(180,12,0,.12);
    }
    .ah-hero-inner { position: relative; z-index: 1; max-width: 720px; }
    .ah-badge {
        display: inline-block; background: rgba(180,12,0,.85); color: #fff;
        padding: 6px 14px; border-radius: 999px; font-size: 12px;
        font-weight: 700; letter-spacing: .07em; text-transform: uppercase; margin-bottom: 14px;
    }
    .ah-h1 { font-size: clamp(28px,4.5vw,52px); line-height: 1.1; font-weight: 800; margin: 0 0 14px; color: #fff; }
    .ah-lead { font-size: clamp(15px,2vw,19px); line-height: 1.6; color: rgba(255,255,255,.9); margin: 0 0 24px; }
    .ah-cta-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .ah-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 13px 22px; font-weight: 700; text-decoration: none; border: 1px solid transparent; font-size: 15px; }
    .ah-btn-primary { background: #b40c00; color: #fff; }
    .ah-btn-primary:hover { background: #b40c00; color: #fff; }
    .ah-btn-light { background: rgba(255,255,255,.15); color: #fff; border-color: rgba(255,255,255,.38); }
    .ah-btn-light:hover { background: rgba(255,255,255,.24); color: #fff; }
    .ah-section { padding: 32px 0; }
    .ah-section-title { font-size: clamp(22px,3vw,32px); font-weight: 800; margin: 0 0 20px; }
    .ah-product-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 16px; }
    .ah-product-card { background: #f4f5f9; border: 1px solid #bfdbfe; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow .2s; }
    .ah-product-card:hover { box-shadow: 0 8px 24px rgba(234,88,12,.12); }
    .ah-product-card.featured { border-color: #1e40af; border-width: 2px; }
    .ah-product-img { width: 100%; height: 190px; object-fit: contain; background: #fff; }
    .ah-product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .ah-product-name { font-size: 14px; font-weight: 700; margin: 0 0 6px; line-height: 1.4; }
    .ah-product-price { font-size: 22px; font-weight: 800; color: #1e40af; margin: 0 0 4px; }
    .ah-product-stock { font-size: 12px; color: #64748b; margin: 0 0 10px; }
    .ah-product-stock.low { color: #dc2626; font-weight: 600; }
    .ah-product-cta { margin-top: auto; display: flex; flex-direction: column; gap: 7px; }
    .ah-btn-card-primary { display: block; text-align: center; background: #b40c00; color: #fff; border-radius: 10px; padding: 10px; font-weight: 700; text-decoration: none; font-size: 14px; }
    .ah-btn-card-primary:hover { background: #b40c00; color: #fff; }
    .ah-btn-card-outline { display: block; text-align: center; background: #f4f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 10px; padding: 9px; font-weight: 600; text-decoration: none; font-size: 14px; }
    .ah-btn-card-outline:hover { border-color: #94a3b8; color: #0f172a; }
    .ah-use-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 14px; }
    .ah-use-card { background: #f4f5f9; border: 1px solid #bfdbfe; border-radius: 14px; padding: 18px; display: flex; gap: 14px; align-items: flex-start; }
    .ah-use-icon { font-size: 28px; flex-shrink: 0; }
    .ah-use-title { font-size: 16px; font-weight: 700; margin: 0 0 5px; }
    .ah-use-desc { margin: 0; color: #475569; font-size: 14px; line-height: 1.6; }
    .ah-highlight-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 12px; }
    .ah-highlight-card { background: #f4f5f9; border: 1px solid #bfdbfe; border-radius: 14px; padding: 18px; }
    .ah-highlight-card h3 { font-size: 15px; font-weight: 700; margin: 0 0 6px; color: #1e40af; }
    .ah-highlight-card p { margin: 0; color: #475569; font-size: 13px; line-height: 1.6; }
    .ah-faq { display: grid; gap: 10px; }
    .ah-faq details { background: #f4f5f9; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px 16px; }
    .ah-faq summary { cursor: pointer; font-weight: 700; font-size: 15px; }
    .ah-faq p { margin: 10px 0 0; color: #475569; line-height: 1.7; font-size: 14px; }
    .ah-cta-band { background: linear-gradient(135deg, #8b0000 0%, #b40c00 100%); border-radius: 20px; padding: 36px; color: #fff; text-align: center; }
    .ah-cta-band h2 { color: #fff; margin: 0 0 10px; font-size: clamp(22px,3vw,32px); }
    .ah-cta-band p { color: rgba(255,255,255,.85); margin: 0 0 22px; font-size: 16px; }
    .ah-cta-band .ah-cta-row { justify-content: center; }
    .ah-footer { margin-top: 24px; border-top: 1px solid #bfdbfe; padding-top: 16px; color: #64748b; font-size: 13px; }
    .ah-policy-links { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 8px; }
    .ah-policy-links a { color: #334155; text-decoration: none; }
    .ah-policy-links a:hover { color: #1e40af; }
    .ah-sticky { position: fixed; left: 0; right: 0; bottom: 0; z-index: 70; background: rgba(124,45,18,.97); backdrop-filter: blur(6px); border-top: 1px solid rgba(251,146,60,.4); padding: 10px 12px; display: none; }
    .ah-sticky-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .ah-sticky a { text-align: center; text-decoration: none; padding: 11px 10px; border-radius: 999px; font-weight: 700; }
    .ah-sticky-call { background: #f4f5f9; color: #0f172a; }
    .ah-sticky-line { background: #b40c00; color: #fff; }
    @media (max-width: 980px) { .ah-product-grid { grid-template-columns: 1fr 1fr; } .ah-highlight-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 720px) { .ah-hero { padding: 32px 20px; } .ah-product-grid { grid-template-columns: 1fr; } .ah-use-grid { grid-template-columns: 1fr; } .ah-highlight-grid { grid-template-columns: 1fr; } .ah-sticky { display: block; } .ah-wrap { padding-bottom: 84px; } }
</style>

<div class="ah-wrap">
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

    <div class="ah-container" style="padding: 24px 0 8px;">

        {{-- Hero --}}
        <section class="ah-hero">
            <div class="ah-hero-inner">
                <div class="ah-badge">Airless Hose Hub</div>
                <h1 class="ah-h1">สายพ่นสีแรงดันสูง Airless Hose ทุกขนาด</h1>
                <p class="ah-lead">สาย 5m 10m 15m ขนาด 1/4 และ 3/8 นิ้ว รองรับแรงดันสูง ใช้กับเครื่องพ่นสี Airless RubyShop ทุกรุ่น พร้อมส่งทั่วไทย</p>
                <div class="ah-cta-row">
                    <a class="ah-btn ah-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ขอคำแนะนำ</a>
                    <a class="ah-btn ah-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Products --}}
        <section class="ah-section">
            <h2 class="ah-section-title">สายพ่นสีแรงดันสูง Airless Hose RubyShop ทุกขนาด</h2>
            <div class="ah-product-grid">
                @foreach ($products as $idx => $p)
                    <div class="ah-product-card{{ $idx === 0 ? " featured" : "" }}">
                        @if ($p["image"])
                            <img class="ah-product-img" src="{{ RvMedia::getImageUrl($p["image"], "origin", false, RvMedia::getDefaultImage()) }}" alt="{{ $p["name"] }}" loading="lazy">
                        @else
                            <div class="ah-product-img" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px;">ไม่มีรูป</div>
                        @endif
                        <div class="ah-product-body">
                            <div class="ah-product-name">{{ $p["name"] }}</div>
                            <div class="ah-product-price">฿{{ $p["price"] }}</div>
                            @if (isset($p["quantity"]))
                                <div class="ah-product-stock{{ $p["quantity"] <= 5 && $p["quantity"] > 0 ? " low" : "" }}">
                                    @if ($p["quantity"] > 0)
                                        เหลือ {{ $p["quantity"] }} ชิ้น
                                    @else
                                        สินค้าหมด
                                    @endif
                                </div>
                            @endif
                            <div class="ah-product-cta">
                                <a class="ah-btn-card-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">สอบถาม / สั่งซื้อ LINE</a>
                                <a class="ah-btn-card-outline" href="{{ $p["url"] }}">ดูรายละเอียดสินค้า</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Use Cases --}}
        <section class="ah-section">
            <h2 class="ah-section-title">เหมาะกับงานแบบไหน?</h2>
            <div class="ah-use-grid">
                @foreach ($useCases as $uc)
                    <div class="ah-use-card">
                        <div class="ah-use-icon">{{ $uc["icon"] }}</div>
                        <div>
                            <div class="ah-use-title">{{ $uc["title"] }}</div>
                            <p class="ah-use-desc">{{ $uc["desc"] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Highlights --}}
        <section class="ah-section">
            <h2 class="ah-section-title">จุดเด่นสายพ่นสีแรงดันสูง RubyShop</h2>
            <div class="ah-highlight-grid">
                @foreach ($highlights as $h)
                    <div class="ah-highlight-card">
                        <h3>{{ $h["title"] }}</h3>
                        <p>{{ $h["desc"] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- FAQ --}}
        <section class="ah-section">
            <h2 class="ah-section-title">คำถามที่พบบ่อย สายพ่นสีแรงดันสูง Airless Hose</h2>
            <div class="ah-faq">
                @foreach ($faqItems as $faq)
                    <details>
                        <summary>{{ $faq["q"] }}</summary>
                        <p>{{ $faq["a"] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        {{-- CTA Band --}}
        <section class="ah-section">
            <div class="ah-cta-band">
                <h2>ไม่แน่ใจว่าสายขนาดไหนเหมาะกับงานคุณ?</h2>
                <p>ปรึกษาทีม RubyShop ฟรี บอกประเภทเครื่องพ่นสีและพื้นที่งาน เราแนะนำสายพ่นสีให้ตรงจุด</p>
                <div class="ah-cta-row">
                    <a class="ah-btn ah-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ฟรี</a>
                    <a class="ah-btn ah-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <div class="ah-footer">
            <div>© {{ date("Y") }} RubyShop Co., Ltd.</div>
            <div class="ah-policy-links">
                @foreach ($policyLinks as $policy)
                    <a href="{{ $policy["url"] }}">{{ $policy["label"] }}</a>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Sticky mobile bar --}}
<div class="ah-sticky">
    <div class="ah-sticky-row">
        <a class="ah-sticky-call" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
        <a class="ah-sticky-line" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE</a>
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
        {"@type":"ListItem","position":2,"name":"สายพ่นสีแรงดันสูง Airless Hose","item":"https://www.rubyshop.co.th/lp/airless-hose"}
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
      "name": "สายพ่นสีแรงดันสูง Airless Hose RubyShop",
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
