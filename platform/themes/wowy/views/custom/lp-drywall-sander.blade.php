@php
    use Botble\Media\Facades\RvMedia;

    $lineUrl = "https://page.line.me/rubyshop168?openQrModal=true&utm_source=website&utm_medium=lp&utm_campaign=drywall-sander&utm_content=line-cta";
    $contactPhoneDisplay = "089-666-7802";
    $contactPhone = "0896667802";

    $policyLinks = [
        ["label" => "นโยบายความเป็นส่วนตัว", "url" => url("/privacy-policy")],
        ["label" => "เงื่อนไขการใช้บริการ", "url" => url("/terms-of-service")],
        ["label" => "นโยบายการคืนสินค้า", "url" => url("/return-policy")],
    ];

    $useCases = [
        ["icon" => "🏗️", "title" => "เตรียมผิวก่อนทาสีหรือสกิมโค้ท", "desc" => "ขัดผิวปูนให้เรียบก่อนฉาบสกิมโค้ท ลดเวลาและแรงงาน งานเนียนสม่ำเสมอกว่าขัดมือ"],
        ["icon" => "🏠", "title" => "งานรีโนเวทบ้านและคอนโด", "desc" => "ขัดผิวเก่าออก เตรียมผิวใหม่ ระบบดูดฝุ่นในตัวช่วยให้ทำงานในบ้านได้โดยไม่ต้องทำความสะอาดเพิ่มมาก"],
        ["icon" => "🏢", "title" => "งานรับเหมาอาคารขนาดใหญ่", "desc" => "รุ่นด้ามยาวอย่าง RB-DWS225B เหมาะกับงานผนังสูงและเพดาน ไม่ต้องใช้นั่งร้าน ประหยัดเวลา"],
        ["icon" => "🔧", "title" => "งานลอกสีเก่าและซ่อมแซม", "desc" => "รุ่น RB-SP01 Paint Remover ขัดและลอกสีเก่าออกก่อนทาใหม่ เหมาะกับงานซ่อมผนังเก่า"],
    ];

    $highlights = [
        ["title" => "ระบบดูดฝุ่นในตัว", "desc" => "ทุกรุ่นมีถุงเก็บฝุ่น ทำงานได้สะอาด ไม่ฟุ้งกระจาย เหมาะกับงานในอาคาร"],
        ["title" => "ใบขัดกลม 7-9 นิ้ว", "desc" => "ครอบคลุมพื้นที่กว้าง ขัดได้รวดเร็วกว่ากระดาษทรายมือหลายเท่า"],
        ["title" => "กระดาษทรายทุกเบอร์", "desc" => "มีกระดาษทรายเบอร์ 80, 120, 150, 180, 240, 320 พร้อมจำหน่ายแยก"],
        ["title" => "รับประกันและอะไหล่", "desc" => "ศูนย์บริการในประเทศ อะไหล่พร้อมส่ง ไม่ต้องรอนำเข้าจากต่างประเทศ"],
        ["title" => "เหมาะทั้งช่างมืออาชีพ", "desc" => "ใช้งานง่าย ทั้งช่างมืออาชีพและผู้รับเหมาทั่วไปสามารถใช้ได้ทันที"],
        ["title" => "ส่งไวทั่วไทย", "desc" => "สินค้าพร้อมส่ง จัดส่ง 1-3 วันทำการ หรือรับที่ร้านได้เลย"],
    ];
@endphp

<style>
    .dws-wrap { background: #f8fafc; color: #0f172a; }
    .dws-container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
    .dws-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1a3a2e 60%, #1e293b 100%);
        border-radius: 24px; padding: 52px 40px; color: #fff;
        position: relative; overflow: hidden;
    }
    .dws-hero::before {
        content: ""; position: absolute; top: -60px; right: -60px;
        width: 320px; height: 320px; border-radius: 50%;
        background: rgba(34,197,94,.12);
    }
    .dws-hero-inner { position: relative; z-index: 1; max-width: 720px; }
    .dws-badge {
        display: inline-block; background: rgba(34,197,94,.85); color: #fff;
        padding: 6px 14px; border-radius: 999px; font-size: 12px;
        font-weight: 700; letter-spacing: .07em; text-transform: uppercase; margin-bottom: 14px;
    }
    .dws-h1 { font-size: clamp(28px,4.5vw,52px); line-height: 1.1; font-weight: 800; margin: 0 0 14px; color: #fff; }
    .dws-lead { font-size: clamp(15px,2vw,19px); line-height: 1.6; color: rgba(255,255,255,.88); margin: 0 0 24px; }
    .dws-cta-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .dws-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 13px 22px; font-weight: 700; text-decoration: none; border: 1px solid transparent; font-size: 15px; }
    .dws-btn-primary { background: #16a34a; color: #fff; }
    .dws-btn-primary:hover { background: #15803d; color: #fff; }
    .dws-btn-light { background: rgba(255,255,255,.14); color: #fff; border-color: rgba(255,255,255,.35); }
    .dws-btn-light:hover { background: rgba(255,255,255,.22); color: #fff; }
    .dws-section { padding: 32px 0; }
    .dws-section-title { font-size: clamp(22px,3vw,32px); font-weight: 800; margin: 0 0 20px; }
    .dws-product-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 16px; }
    .dws-product-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow .2s; }
    .dws-product-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.1); }
    .dws-product-card.featured { border-color: #16a34a; border-width: 2px; }
    .dws-product-img { width: 100%; height: 190px; object-fit: contain; background: #fff; }
    .dws-product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .dws-product-name { font-size: 14px; font-weight: 700; margin: 0 0 8px; line-height: 1.4; }
    .dws-product-price { font-size: 22px; font-weight: 800; color: #16a34a; margin: 0 0 12px; }
    .dws-product-cta { margin-top: auto; display: flex; flex-direction: column; gap: 7px; }
    .dws-btn-card-primary { display: block; text-align: center; background: #16a34a; color: #fff; border-radius: 10px; padding: 10px; font-weight: 700; text-decoration: none; font-size: 14px; }
    .dws-btn-card-primary:hover { background: #15803d; color: #fff; }
    .dws-btn-card-outline { display: block; text-align: center; background: #f4f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 10px; padding: 9px; font-weight: 600; text-decoration: none; font-size: 14px; }
    .dws-btn-card-outline:hover { border-color: #94a3b8; color: #0f172a; }
    .dws-use-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 14px; }
    .dws-use-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; display: flex; gap: 14px; align-items: flex-start; }
    .dws-use-icon { font-size: 28px; flex-shrink: 0; }
    .dws-use-title { font-size: 16px; font-weight: 700; margin: 0 0 5px; }
    .dws-use-desc { margin: 0; color: #475569; font-size: 14px; line-height: 1.6; }
    .dws-highlight-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 12px; }
    .dws-highlight-card { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; }
    .dws-highlight-card h3 { font-size: 15px; font-weight: 700; margin: 0 0 6px; }
    .dws-highlight-card p { margin: 0; color: #475569; font-size: 13px; line-height: 1.6; }
    .dws-faq { display: grid; gap: 10px; }
    .dws-faq details { background: #f4f5f9; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; }
    .dws-faq summary { cursor: pointer; font-weight: 700; font-size: 15px; }
    .dws-faq p { margin: 10px 0 0; color: #475569; line-height: 1.7; font-size: 14px; }
    .dws-cta-band { background: #0f172a; border-radius: 20px; padding: 36px; color: #fff; text-align: center; }
    .dws-cta-band h2 { color: #fff; margin: 0 0 10px; font-size: clamp(22px,3vw,32px); }
    .dws-cta-band p { color: rgba(255,255,255,.82); margin: 0 0 22px; font-size: 16px; }
    .dws-cta-band .dws-cta-row { justify-content: center; }
    .dws-footer { margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 16px; color: #64748b; font-size: 13px; }
    .dws-policy-links { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 8px; }
    .dws-policy-links a { color: #334155; text-decoration: none; }
    .dws-policy-links a:hover { color: #16a34a; }
    .dws-sticky { position: fixed; left: 0; right: 0; bottom: 0; z-index: 70; background: rgba(15,23,42,.96); backdrop-filter: blur(6px); border-top: 1px solid rgba(148,163,184,.3); padding: 10px 12px; display: none; }
    .dws-sticky-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .dws-sticky a { text-align: center; text-decoration: none; padding: 11px 10px; border-radius: 999px; font-weight: 700; }
    .dws-sticky-call { background: #f4f5f9; color: #0f172a; }
    .dws-sticky-line { background: #16a34a; color: #fff; }
    @media (max-width: 980px) { .dws-product-grid { grid-template-columns: 1fr 1fr; } .dws-highlight-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 720px) { .dws-hero { padding: 32px 20px; } .dws-product-grid { grid-template-columns: 1fr; } .dws-use-grid { grid-template-columns: 1fr; } .dws-highlight-grid { grid-template-columns: 1fr; } .dws-sticky { display: block; } .dws-wrap { padding-bottom: 84px; } }
</style>

<div class="dws-wrap">
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

    <div class="dws-container" style="padding: 24px 0 8px;">

        {{-- Hero --}}
        <section class="dws-hero">
            <div class="dws-hero-inner">
                <div class="dws-badge">Drywall Sander Hub</div>
                <h1 class="dws-h1">เครื่องขัดผนัง ดูดฝุ่นในตัว<br>ครบทุกรุ่น RubyShop</h1>
                <p class="dws-lead">เปรียบเทียบเครื่องขัดผนัง (Drywall Sander) ทุกรุ่น ระบบดูดฝุ่นในตัว เตรียมผิวสกิมโค้ท งานเนียน ไม่ฝุ่น</p>
                <div class="dws-cta-row">
                    <a class="dws-btn dws-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ขอคำแนะนำ</a>
                    <a class="dws-btn dws-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Products --}}
        <section class="dws-section">
            <h2 class="dws-section-title">เปรียบเทียบเครื่องขัดผนัง RubyShop ทุกรุ่น</h2>
            <div class="dws-product-grid">
                @foreach ($products as $idx => $p)
                    <div class="dws-product-card{{ $idx === 0 ? " featured" : "" }}">
                        @if ($p["image"])
                            <img class="dws-product-img" src="{{ RvMedia::getImageUrl($p["image"], "origin", false, RvMedia::getDefaultImage()) }}" alt="{{ $p["name"] }}" loading="lazy">
                        @else
                            <div class="dws-product-img" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px;">ไม่มีรูป</div>
                        @endif
                        <div class="dws-product-body">
                            <div class="dws-product-name">{{ $p["name"] }}</div>
                            <div class="dws-product-price">฿{{ $p["price"] }}</div>
                            <div class="dws-product-cta">
                                <a class="dws-btn-card-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">สอบถาม / สั่งซื้อ LINE</a>
                                <a class="dws-btn-card-outline" href="{{ $p["url"] }}">ดูรายละเอียดสินค้า</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Use Cases --}}
        <section class="dws-section">
            <h2 class="dws-section-title">เหมาะกับงานแบบไหน?</h2>
            <div class="dws-use-grid">
                @foreach ($useCases as $uc)
                    <div class="dws-use-card">
                        <div class="dws-use-icon">{{ $uc["icon"] }}</div>
                        <div>
                            <div class="dws-use-title">{{ $uc["title"] }}</div>
                            <p class="dws-use-desc">{{ $uc["desc"] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Highlights --}}
        <section class="dws-section">
            <h2 class="dws-section-title">จุดเด่นเครื่องขัดผนัง RubyShop</h2>
            <div class="dws-highlight-grid">
                @foreach ($highlights as $h)
                    <div class="dws-highlight-card">
                        <h3>{{ $h["title"] }}</h3>
                        <p>{{ $h["desc"] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- FAQ --}}
        <section class="dws-section">
            <h2 class="dws-section-title">คำถามที่พบบ่อย เครื่องขัดผนัง</h2>
            <div class="dws-faq">
                @foreach ($faqItems as $faq)
                    <details>
                        <summary>{{ $faq["q"] }}</summary>
                        <p>{{ $faq["a"] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        {{-- CTA Band --}}
        <section class="dws-section">
            <div class="dws-cta-band">
                <h2>ไม่แน่ใจว่ารุ่นไหนเหมาะกับงานคุณ?</h2>
                <p>ปรึกษาทีม RubyShop ฟรี บอกประเภทผิวงานและพื้นที่ เราแนะนำเครื่องขัดผนังให้ตรงจุด</p>
                <div class="dws-cta-row">
                    <a class="dws-btn dws-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ฟรี</a>
                    <a class="dws-btn dws-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <div class="dws-footer">
            <div>© {{ date("Y") }} RubyShop Co., Ltd.</div>
            <div class="dws-policy-links">
                @foreach ($policyLinks as $policy)
                    <a href="{{ $policy["url"] }}">{{ $policy["label"] }}</a>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Sticky mobile bar --}}
<div class="dws-sticky">
    <div class="dws-sticky-row">
        <a class="dws-sticky-call" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
        <a class="dws-sticky-line" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE</a>
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
        {"@type":"ListItem","position":2,"name":"เครื่องขัดผนัง","item":"https://www.rubyshop.co.th/lp/drywall-sander"}
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
      "name": "เครื่องขัดผนัง RubyShop",
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
