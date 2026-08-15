@php
    use Botble\Media\Facades\RvMedia;

    $lineUrl = 'https://page.line.me/rubyshop168?openQrModal=true&utm_source=website&utm_medium=lp&utm_campaign=airless-hub&utm_content=line-cta';
    $contactPhoneDisplay = '089-666-7802';
    $contactPhone = '0896667802';

    $policyLinks = [
        ['label' => 'นโยบายความเป็นส่วนตัว', 'url' => url('/privacy-policy')],
        ['label' => 'เงื่อนไขการใช้บริการ', 'url' => url('/terms-of-service')],
        ['label' => 'นโยบายการคืนสินค้า', 'url' => url('/return-policy')],
    ];

    $useCases = [
        ['img' => '/storage/lp/use-construction.jpg', 'title' => 'งานรับเหมาก่อสร้าง', 'desc' => 'ต้องการพ่นสีพื้นที่ใหญ่ เร็ว และต่อเนื่อง → เลือก RB899 กำลังสูง พ่นได้หนักทั้งวัน'],
        ['img' => '/storage/lp/use-renovation.jpg', 'title' => 'รีโนเวทบ้าน / คอนโด', 'desc' => 'งานขนาดกลาง ต้องการสีเนียน ประหยัดพลังงาน → RB5300 Inverter ตอบโจทย์'],
        ['img' => '/storage/lp/use-furniture.jpg', 'title' => 'งานเฟอร์นิเจอร์ / ไม้', 'desc' => 'ควบคุมละเอียด ผิวงานสม่ำเสมอ → RB-360S น้ำหนักเบา จัดการได้ง่าย'],
        ['img' => '/storage/lp/use-industrial.jpg', 'title' => 'งานโรงงาน / อุตสาหกรรม', 'desc' => 'พ่นสีอีพ็อกซี่ สีพิเศษ ปริมาณมาก → RB899 แรงดันสูง รองรับสีทุกประเภท'],
    ];

    $highlights = [
        ['title' => 'ศูนย์บริการในประเทศ', 'desc' => 'มีทีมช่างเทคนิคคอยดูแลหลังการขาย ไม่ต้องส่งซ่อมต่างประเทศ'],
        ['title' => 'อะไหล่และหัวทิปพร้อมส่ง', 'desc' => 'หัวทิปทุกขนาด 515 517 519 521 อะไหล่สำรองพร้อมจัดส่งทั่วไทย'],
        ['title' => 'ทีมงานให้คำแนะนำ', 'desc' => 'ปรึกษาฟรีก่อนเลือกรุ่น แนะนำตามประเภทงานจริง ไม่ขายเกินความต้องการ'],
        ['title' => 'ส่งไว ทั่วไทย', 'desc' => 'สินค้าพร้อมส่ง จัดส่ง 1-3 วันทำการ หรือรับที่ร้านได้เลย'],
        ['title' => 'สต็อกครบทุกรุ่น', 'desc' => 'ไม่ต้องรอสั่ง สินค้าพร้อม ไม่เสียเวลางาน'],
        ['title' => 'ราคาตรงไม่มีบวกเพิ่ม', 'desc' => 'ราคาหน้าเว็บคือราคาจริง ไม่มีค่าใช้จ่ายซ่อน'],
    ];
@endphp

<style>
    .airless-wrap { background: #f8fafc; color: #0f172a; }
    .airless-container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }

    /* Hero */
    .airless-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1e293b 100%);
        border-radius: 24px;
        padding: 52px 40px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .airless-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: rgba(220, 38, 38, .12);
    }
    .airless-hero-inner { position: relative; z-index: 1; max-width: 720px; }
    .airless-badge {
        display: inline-block;
        background: rgba(220, 38, 38, .9);
        color: #fff;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }
    .airless-h1 { font-size: clamp(28px, 4.5vw, 52px); line-height: 1.1; font-weight: 800; margin: 0 0 14px; color: #fff; }
    .airless-lead { font-size: clamp(15px, 2vw, 19px); line-height: 1.6; color: rgba(255,255,255,.88); margin: 0 0 24px; }
    .airless-cta-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .airless-btn {
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 999px; padding: 13px 22px;
        font-weight: 700; text-decoration: none; border: 1px solid transparent;
        font-size: 15px;
    }
    .airless-btn-primary { background: #dc2626; color: #fff; }
    .airless-btn-primary:hover { background: #b91c1c; color: #fff; }
    .airless-btn-light { background: rgba(255,255,255,.14); color: #fff; border-color: rgba(255,255,255,.35); }
    .airless-btn-light:hover { background: rgba(255,255,255,.22); color: #fff; }

    /* Section */
    .airless-section { padding: 32px 0; }
    .airless-section-title { font-size: clamp(22px, 3vw, 32px); font-weight: 800; margin: 0 0 20px; }

    /* Comparison cards */
    .airless-compare-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }
    .airless-product-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s;
    }
    .airless-product-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.1); }
    .airless-product-card.featured { border-color: #dc2626; border-width: 2px; }
    .airless-product-img {
        width: 100%; height: 200px;
        object-fit: contain;
        background: #fff;
    }
    .airless-product-body { padding: 18px; flex: 1; display: flex; flex-direction: column; }
    .airless-product-badge {
        display: inline-block;
        font-size: 11px; font-weight: 700;
        padding: 3px 10px; border-radius: 999px;
        margin-bottom: 8px;
        background: #fef2f2; color: #dc2626;
        text-transform: uppercase; letter-spacing: .05em;
    }
    .airless-product-badge.blue { background: #eff6ff; color: #1d4ed8; }
    .airless-product-badge.green { background: #f0fdf4; color: #166534; }
    .airless-product-name { font-size: 16px; font-weight: 700; margin: 0 0 8px; line-height: 1.35; }
    .airless-product-price { font-size: 24px; font-weight: 800; color: #dc2626; margin: 0 0 10px; }
    .airless-product-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 12px; }
    .airless-tag {
        font-size: 12px; padding: 3px 9px; border-radius: 6px;
        background: #f1f5f9; color: #475569;
    }
    .airless-product-cta {
        margin-top: auto;
        display: flex; flex-direction: column; gap: 7px;
    }
    .airless-btn-card-primary {
        display: block; text-align: center;
        background: #dc2626; color: #fff;
        border-radius: 10px; padding: 10px;
        font-weight: 700; text-decoration: none; font-size: 14px;
    }
    .airless-btn-card-primary:hover { background: #b91c1c; color: #fff; }
    .airless-btn-card-outline {
        display: block; text-align: center;
        background: #fff; color: #0f172a;
        border: 1px solid #cbd5e1;
        border-radius: 10px; padding: 9px;
        font-weight: 600; text-decoration: none; font-size: 14px;
    }
    .airless-btn-card-outline:hover { border-color: #94a3b8; color: #0f172a; }

    /* Use-case grid */
    .airless-use-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }
    .airless-use-card {
        background: #f4f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }
    .airless-use-icon { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; flex-shrink: 0; }
    .airless-use-title { font-size: 16px; font-weight: 700; margin: 0 0 5px; }
    .airless-use-desc { margin: 0; color: #475569; font-size: 14px; line-height: 1.6; }

    /* Highlights */
    .airless-highlight-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }
    .airless-highlight-card {
        background: #f4f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
    }
    .airless-highlight-card h3 { font-size: 15px; font-weight: 700; margin: 0 0 6px; }
    .airless-highlight-card p { margin: 0; color: #475569; font-size: 13px; line-height: 1.6; }

    /* FAQ */
    .airless-faq { display: grid; gap: 10px; }
    .airless-faq details {
        background: #f4f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
    }
    .airless-faq summary { cursor: pointer; font-weight: 700; font-size: 15px; }
    .airless-faq p { margin: 10px 0 0; color: #475569; line-height: 1.7; font-size: 14px; }

    /* CTA Band */
    .airless-cta-band {
        background: #0f172a;
        border-radius: 20px;
        padding: 36px;
        color: #fff;
        text-align: center;
    }
    .airless-cta-band h2 { color: #fff; margin: 0 0 10px; font-size: clamp(22px, 3vw, 32px); }
    .airless-cta-band p { color: rgba(255,255,255,.82); margin: 0 0 22px; font-size: 16px; }
    .airless-cta-band .airless-cta-row { justify-content: center; }

    /* Footer */
    .airless-footer {
        margin-top: 24px;
        border-top: 1px solid #e2e8f0;
        padding-top: 16px;
        color: #64748b;
        font-size: 13px;
    }
    .airless-policy-links { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 8px; }
    .airless-policy-links a { color: #334155; text-decoration: none; }
    .airless-policy-links a:hover { color: #dc2626; }

    /* Sticky bar */
    .airless-sticky {
        position: fixed;
        left: 0; right: 0; bottom: 0;
        z-index: 70;
        background: rgba(15,23,42,.96);
        backdrop-filter: blur(6px);
        border-top: 1px solid rgba(148,163,184,.3);
        padding: 10px 12px;
        display: none;
    }
    .airless-sticky-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .airless-sticky a {
        text-align: center; text-decoration: none;
        padding: 11px 10px; border-radius: 999px; font-weight: 700;
    }
    .airless-sticky-call { background: #f4f5f9; color: #0f172a; }
    .airless-sticky-line { background: #dc2626; color: #fff; }

    /* Responsive */
    @media (max-width: 980px) {
        .airless-compare-grid { grid-template-columns: 1fr 1fr; }
        .airless-highlight-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 720px) {
        .airless-hero { padding: 32px 20px; }
        .airless-compare-grid { grid-template-columns: 1fr; }
        .airless-use-grid { grid-template-columns: 1fr; }
        .airless-highlight-grid { grid-template-columns: 1fr; }
        .airless-sticky { display: block; }
        .airless-wrap { padding-bottom: 84px; }
    }
</style>

<div class="airless-wrap">
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

    <div class="airless-container" style="padding: 24px 0 8px;">

        {{-- Hero --}}
        <section class="airless-hero">
            <div class="airless-hero-inner">
                <div class="airless-badge">Airless Sprayer Hub</div>
                <h1 class="airless-h1">เครื่องพ่นสีแรงดันสูง<br>(Airless Sprayer)</h1>
                <p class="airless-lead">เปรียบเทียบทุกรุ่น RubyShop ดูราคา สเปก และเลือกรุ่นที่เหมาะกับงานคุณ พร้อมทีมแนะนำฟรีก่อนซื้อ</p>
                <div class="airless-cta-row">
                    <a class="airless-btn airless-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ขอคำแนะนำ</a>
                    <a class="airless-btn airless-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Product Comparison --}}
        <section class="airless-section">
            <h2 class="airless-section-title">เปรียบเทียบเครื่องพ่นสีแรงดันสูง RubyShop ทุกรุ่น</h2>
            <div class="airless-compare-grid">
                @foreach ($products as $idx => $p)
                    @php
                        $badges = ['แรงสูง', 'ประหยัดพลังงาน', 'น้ำหนักเบา'];
                        $badgeClasses = ['', 'blue', 'green'];
                        $tagGroups = [
                            ['งานรับเหมา', 'พื้นที่กว้าง', 'สีหนืด'],
                            ['Inverter', 'ประหยัดไฟ', 'งานกลาง'],
                            ['ขนาดเล็ก', 'งานบ้าน', 'คล่องตัว'],
                        ];
                        $isFeatured = $idx === 0;
                    @endphp
                    <div class="airless-product-card{{ $isFeatured ? ' featured' : '' }}">
                        @if ($p['image'])
                            <img
                                class="airless-product-img"
                                src="{{ RvMedia::getImageUrl($p['image'], 'origin', false, RvMedia::getDefaultImage()) }}"
                                alt="{{ $p['name'] }}"
                                loading="lazy"
                            >
                        @else
                            <div class="airless-product-img" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px;">ไม่มีรูป</div>
                        @endif
                        <div class="airless-product-body">
                            <span class="airless-product-badge {{ $badgeClasses[$idx] ?? '' }}">{{ $badges[$idx] ?? 'รุ่นยอดนิยม' }}</span>
                            <div class="airless-product-name">{{ $p['name'] }}</div>
                            <div class="airless-product-price">฿{{ $p['price'] }}</div>
                            <div class="airless-product-tags">
                                @foreach (($tagGroups[$idx] ?? []) as $tag)
                                    <span class="airless-tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <div class="airless-product-cta">
                                <a class="airless-btn-card-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">สอบถาม / สั่งซื้อ LINE</a>
                                <a class="airless-btn-card-outline" href="{{ $p['url'] }}">ดูรายละเอียดสินค้า</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Use Cases --}}
        <section class="airless-section">
            <h2 class="airless-section-title">เหมาะกับงานแบบไหน?</h2>
            <div class="airless-use-grid">
                @foreach ($useCases as $uc)
                    <div class="airless-use-card">
                        <img class="airless-use-icon" src="{{ $uc['img'] }}" alt="{{ $uc['title'] }}" loading="lazy">
                        <div>
                            <div class="airless-use-title">{{ $uc['title'] }}</div>
                            <p class="airless-use-desc">{{ $uc['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Highlights --}}
        <section class="airless-section">
            <h2 class="airless-section-title">จุดเด่น RubyShop ที่ช่างมืออาชีพเลือก</h2>
            <div class="airless-highlight-grid">
                @foreach ($highlights as $h)
                    <div class="airless-highlight-card">
                        <h3>{{ $h['title'] }}</h3>
                        <p>{{ $h['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- FAQ --}}
        <section class="airless-section">
            <h2 class="airless-section-title">คำถามที่พบบ่อย เครื่องพ่นสีแรงดันสูง</h2>
            <div class="airless-faq">
                @foreach ($faqItems as $faq)
                    <details>
                        <summary>{{ $faq['q'] }}</summary>
                        <p>{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        {{-- CTA Band --}}
        <section class="airless-section">
            <div class="airless-cta-band">
                <h2>ไม่แน่ใจว่ารุ่นไหนเหมาะกับงานคุณ?</h2>
                <p>ปรึกษาทีม RubyShop ฟรี บอกประเภทงานและพื้นที่ เราแนะนำรุ่นให้ตรงจุด ไม่ขายเกินความต้องการ</p>
                <div class="airless-cta-row">
                    <a class="airless-btn airless-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ฟรี</a>
                    <a class="airless-btn airless-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <div class="airless-footer">
            <div>© {{ date('Y') }} RubyShop Co., Ltd.</div>
            <div class="airless-policy-links">
                @foreach ($policyLinks as $policy)
                    <a href="{{ $policy['url'] }}">{{ $policy['label'] }}</a>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Sticky mobile bar --}}
<div class="airless-sticky">
    <div class="airless-sticky-row">
        <a class="airless-sticky-call" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
        <a class="airless-sticky-line" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE</a>
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
        {"@type":"ListItem","position":2,"name":"เครื่องพ่นสีแรงดันสูง","item":"https://www.rubyshop.co.th/lp/airless-sprayer-thailand"}
      ]
    },
    {
      "@type": "FAQPage",
      "mainEntity": [
        @foreach($faqItems as $faq)
        {
          "@type": "Question",
          "name": "{{ $faq['q'] }}",
          "acceptedAnswer": {"@type": "Answer", "text": "{{ $faq['a'] }}"}
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
      ]
    },
    {
      "@type": "ItemList",
      "name": "เครื่องพ่นสีแรงดันสูง RubyShop",
      "itemListElement": [
        @foreach($products as $i => $p)
        {
          "@type": "ListItem",
          "position": {{ $i + 1 }},
          "item": {
            "@type": "Product",
            "name": "{{ $p['name'] }}",
            "url": "{{ $p['url'] }}",
            "offers": {"@type": "Offer", "price": "{{ $p['price_raw'] }}", "priceCurrency": "THB", "availability": "https://schema.org/InStock"}
          }
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
      ]
    }
  ]
}
</script>
