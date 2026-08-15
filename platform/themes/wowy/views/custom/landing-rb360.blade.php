@php
    use Botble\Media\Facades\RvMedia;

    $heroImage = $gallery->first() ?: $product->image;
    $safeDescription = trim(strip_tags((string) ($product->description ?: $product->content)));
    $safeDescription = $safeDescription !== '' ? $safeDescription : 'เครื่องพ่นสีแรงดันสูง RB-360 น้ำหนักเบา พลังสูง สำหรับงานช่างมืออาชีพ';
    $salePrice = $price ?: $product->front_sale_price_with_taxes;
    $fullPrice = $oldPrice ?: $product->price_with_taxes;
    $reviewCount = (int) ($product->reviews_count ?? 0);
    $trackingQueryString = ! empty($trackingQuery) ? ('?' . http_build_query($trackingQuery)) : '';
    $productUrl = $product->url . $trackingQueryString;
    $policyLinks = [
        ['label' => 'นโยบายความเป็นส่วนตัว', 'url' => url('/privacy-policy')],
        ['label' => 'เงื่อนไขการใช้บริการ', 'url' => url('/terms-of-service')],
        ['label' => 'นโยบายการคืนสินค้า', 'url' => url('/return-policy')],
    ];
    $contactAction = \Illuminate\Support\Facades\Route::has('public.send.contact') ? route('public.send.contact') : null;
@endphp

<style>
    .rb360-wrap { background: #f8fafc; color: #0f172a; }
    .rb360-container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
    .rb360-hero {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        min-height: 560px;
        display: grid;
        align-items: end;
        background: #111827;
    }
    .rb360-hero-image {
        position: absolute; inset: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        opacity: .4;
    }
    .rb360-hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(120deg, rgba(2, 6, 23, .88) 0%, rgba(15, 23, 42, .45) 55%, rgba(15, 23, 42, .20) 100%);
    }
    .rb360-hero-content {
        position: relative;
        z-index: 2;
        padding: 40px;
        color: #fff;
        max-width: 760px;
    }
    .rb360-badge {
        display: inline-block;
        background: rgba(220, 38, 38, .95);
        color: #fff;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    .rb360-title { font-size: clamp(30px, 5vw, 58px); line-height: 1.06; margin: 0 0 14px; font-weight: 800; }
    .rb360-subtitle { margin: 0; font-size: clamp(16px, 2.2vw, 22px); line-height: 1.55; color: rgba(255, 255, 255, .92); }
    .rb360-price {
        margin-top: 22px;
        display: flex;
        align-items: baseline;
        gap: 12px;
        flex-wrap: wrap;
    }
    .rb360-price-sale { font-size: clamp(28px, 4.5vw, 46px); font-weight: 800; color: #fca5a5; }
    .rb360-price-old { font-size: 20px; text-decoration: line-through; color: rgba(255, 255, 255, .62); }
    .rb360-cta-row { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 24px; }
    .rb360-btn {
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 999px; padding: 12px 20px;
        font-weight: 700; text-decoration: none; border: 1px solid transparent;
    }
    .rb360-btn-primary { background: #dc2626; color: #fff; }
    .rb360-btn-primary:hover { background: #b91c1c; color: #fff; }
    .rb360-btn-light { background: rgba(255, 255, 255, .14); color: #fff; border-color: rgba(255, 255, 255, .35); }
    .rb360-btn-light:hover { background: rgba(255, 255, 255, .2); color: #fff; }
    .rb360-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 20px;
    }
    .rb360-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
    }
    .rb360-card h3 { margin: 0 0 6px; font-size: 18px; }
    .rb360-card p { margin: 0; color: #475569; line-height: 1.65; font-size: 14px; }
    .rb360-section { padding: 28px 0; }
    .rb360-section h2 { margin: 0 0 12px; font-size: clamp(24px, 3vw, 34px); }
    .rb360-spec {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .rb360-spec td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
    }
    .rb360-spec tr:last-child td { border-bottom: none; }
    .rb360-spec td:first-child { width: 36%; background: #f8fafc; font-weight: 700; color: #334155; }
    .rb360-gallery {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
    }
    .rb360-gallery img {
        width: 100%; height: 220px; object-fit: cover;
        border-radius: 12px; border: 1px solid #e2e8f0;
        background: #fff;
    }
    .rb360-faq { display: grid; gap: 10px; }
    .rb360-faq details {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
    }
    .rb360-faq summary { cursor: pointer; font-weight: 700; }
    .rb360-faq p { margin: 8px 0 0; color: #475569; line-height: 1.65; }
    .rb360-form-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
    }
    .rb360-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .rb360-field { display: flex; flex-direction: column; gap: 6px; }
    .rb360-field label { font-size: 13px; font-weight: 700; color: #334155; }
    .rb360-field input,
    .rb360-field select,
    .rb360-field textarea {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 14px;
        line-height: 1.4;
        width: 100%;
    }
    .rb360-field textarea { min-height: 100px; resize: vertical; }
    .rb360-form-alert {
        margin-top: 10px;
        font-size: 13px;
        border-radius: 10px;
        padding: 10px 12px;
        display: none;
    }
    .rb360-form-alert.ok { background: #ecfdf5; color: #166534; border: 1px solid #86efac; }
    .rb360-form-alert.err { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
    .rb360-footer {
        margin-top: 26px;
        border-top: 1px solid #e2e8f0;
        padding-top: 16px;
        color: #64748b;
        font-size: 13px;
    }
    .rb360-policy-links { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 8px; }
    .rb360-policy-links a { color: #334155; text-decoration: none; }
    .rb360-policy-links a:hover { color: #dc2626; }
    .rb360-sticky {
        position: fixed;
        left: 0; right: 0; bottom: 0;
        z-index: 70;
        background: rgba(15, 23, 42, .95);
        backdrop-filter: blur(6px);
        border-top: 1px solid rgba(148, 163, 184, .35);
        padding: 10px 12px;
        display: none;
    }
    .rb360-sticky-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .rb360-sticky a {
        text-align: center; text-decoration: none;
        padding: 11px 10px; border-radius: 999px; font-weight: 700;
    }
    .rb360-sticky-call { background: #fff; color: #0f172a; }
    .rb360-sticky-line { background: #dc2626; color: #fff; }
    @media (max-width: 980px) {
        .rb360-grid { grid-template-columns: 1fr 1fr; }
        .rb360-gallery { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 720px) {
        .rb360-hero-content { padding: 24px 18px 20px; }
        .rb360-grid { grid-template-columns: 1fr; }
        .rb360-gallery { grid-template-columns: 1fr; }
        .rb360-sticky { display: block; }
        .rb360-wrap { padding-bottom: 84px; }
        .rb360-form-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="rb360-wrap">
    <div class="rb360-container" style="padding: 24px 0 8px;">
        <section class="rb360-hero">
            <img class="rb360-hero-image" src="{{ RvMedia::getImageUrl($heroImage, 'origin', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
            <div class="rb360-hero-overlay"></div>
            <div class="rb360-hero-content">
                <div class="rb360-badge">Google Ads Landing</div>
                <h1 class="rb360-title">RUBYSHOP RB-360 เครื่องพ่นสีแรงดันสูง น้ำหนักเบา พ่นงานไว</h1>
                <p class="rb360-subtitle">{{ $safeDescription }}</p>
                <div class="rb360-price">
                    <span class="rb360-price-sale">{{ format_price($salePrice) }}</span>
                    @if ($fullPrice > $salePrice)
                        <span class="rb360-price-old">{{ format_price($fullPrice) }}</span>
                    @endif
                </div>
                <div class="rb360-cta-row">
                    <a class="rb360-btn rb360-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE ขอราคา</a>
                    <a class="rb360-btn rb360-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                    <a class="rb360-btn rb360-btn-light" href="{{ $productUrl }}">ดูหน้าสินค้าเต็ม</a>
                </div>
            </div>
        </section>

        <section class="rb360-section">
            <div class="rb360-grid">
                <div class="rb360-card">
                    <h3>พ่นได้ต่อเนื่อง</h3>
                    <p>เหมาะสำหรับงานพ่นสีหน้างานจริงที่ต้องการความเร็วและคุณภาพผิวงานที่สม่ำเสมอ</p>
                </div>
                <div class="rb360-card">
                    <h3>เครื่องคล่องตัว</h3>
                    <p>RB-360 ถูกออกแบบให้ใช้งานง่าย เคลื่อนย้ายสะดวก เหมาะกับทีมช่างที่ทำงานหลายจุด</p>
                </div>
                <div class="rb360-card">
                    <h3>มีทีมซัพพอร์ต</h3>
                    <p>แนะนำการใช้งานและบริการหลังการขายผ่านช่องทางติดต่อของ Rubyshop</p>
                </div>
            </div>
        </section>

        <section class="rb360-section">
            <h2>สเปกและคุณสมบัติหลัก</h2>
            @if ($specifications->isNotEmpty())
                <table class="rb360-spec">
                    <tbody>
                        @foreach ($specifications as $spec)
                            <tr>
                                <td>{{ $spec->title }}</td>
                                <td>{!! BaseHelper::clean($spec->pivot->value) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table class="rb360-spec">
                    <tbody>
                        <tr><td>รุ่น</td><td>RB-360</td></tr>
                        <tr><td>จุดเด่น</td><td>น้ำหนักเบา เคลื่อนย้ายง่าย ประสิทธิภาพการพ่นสูง</td></tr>
                        <tr><td>เหมาะกับงาน</td><td>งานพ่นสีอาคาร งานรีโนเวท งานช่างมืออาชีพ</td></tr>
                    </tbody>
                </table>
            @endif
        </section>

        @if ($gallery->isNotEmpty())
            <section class="rb360-section">
                <h2>ภาพสินค้าจริง</h2>
                <div class="rb360-gallery">
                    @foreach ($gallery->take(8) as $image)
                        <img src="{{ RvMedia::getImageUrl($image, 'origin', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                    @endforeach
                </div>
            </section>
        @endif

        <section class="rb360-section">
            <h2>คำถามที่พบบ่อย</h2>
            <div class="rb360-faq">
                @foreach ($faqItems as $faq)
                    <details>
                        <summary>{{ $faq['q'] }}</summary>
                        <p>{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        <section class="rb360-section" id="lead-form">
            <h2>ขอใบเสนอราคา RB-360</h2>
            <div class="rb360-form-wrap">
                @if ($contactAction)
                    <form id="rb360LeadForm" method="POST" action="{{ $contactAction }}">
                        @csrf
                        <input type="hidden" name="subject" value="Lead Google Ads - RB-360">
                        <input type="hidden" name="content" id="rb360LeadContent" value="">
                        <div class="rb360-form-grid">
                            <div class="rb360-field">
                                <label for="lead_name">ชื่อผู้ติดต่อ</label>
                                <input id="lead_name" name="name" type="text" required placeholder="กรอกชื่อ">
                            </div>
                            <div class="rb360-field">
                                <label for="lead_phone">เบอร์โทรศัพท์</label>
                                <input id="lead_phone" name="phone" type="tel" required placeholder="089-666-7802">
                            </div>
                            <div class="rb360-field">
                                <label for="lead_email">อีเมล</label>
                                <input id="lead_email" name="email" type="email" placeholder="you@example.com">
                            </div>
                            <div class="rb360-field">
                                <label for="lead_budget">งบประมาณโดยประมาณ</label>
                                <select id="lead_budget">
                                    <option value="">เลือกงบประมาณ</option>
                                    <option value="ต่ำกว่า 30,000 บาท">ต่ำกว่า 30,000 บาท</option>
                                    <option value="30,000 - 50,000 บาท">30,000 - 50,000 บาท</option>
                                    <option value="50,000+ บาท">50,000+ บาท</option>
                                </select>
                            </div>
                            <div class="rb360-field" style="grid-column: 1 / -1;">
                                <label for="lead_message">รายละเอียดงาน</label>
                                <textarea id="lead_message" placeholder="บอกประเภทงาน พื้นที่หน้างาน และเวลาที่ต้องการใช้งาน"></textarea>
                            </div>
                        </div>
                        <div class="rb360-cta-row" style="margin-top:14px;">
                            <button type="submit" id="rb360LeadSubmit" class="rb360-btn rb360-btn-primary" data-ads-cta="rb360-form-submit">ส่งข้อมูลขอราคา</button>
                            <a class="rb360-btn rb360-btn-light" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer" data-ads-cta="rb360-form-line">ส่งงานผ่าน LINE</a>
                        </div>
                        <div id="rb360LeadOk" class="rb360-form-alert ok">ส่งข้อมูลเรียบร้อย ทีมงานจะติดต่อกลับโดยเร็วที่สุด</div>
                        <div id="rb360LeadErr" class="rb360-form-alert err">ส่งข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง</div>
                    </form>
                @else
                    <p style="margin:0;color:#475569;">ระบบฟอร์มติดต่อยังไม่พร้อมใช้งานในสภาพแวดล้อมนี้ กรุณาติดต่อผ่านโทรศัพท์หรือ LINE</p>
                @endif
            </div>
        </section>

        <section class="rb360-section">
            <div class="rb360-card" style="background:#0f172a;color:#fff;border-color:#0f172a;">
                <h3 style="color:#fff;font-size:26px;margin-bottom:8px;">พร้อมปิดงานไวขึ้นด้วย RB-360?</h3>
                <p style="color:rgba(255,255,255,.88);font-size:16px;">ติดต่อทีม Rubyshop เพื่อขอราคา อัปเดตโปรโมชัน และแนะนำรุ่นให้เหมาะกับหน้างานของคุณ</p>
                <div class="rb360-cta-row">
                    <a class="rb360-btn rb360-btn-primary" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">ขอใบเสนอราคา</a>
                    <a class="rb360-btn rb360-btn-light" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
                    <a class="rb360-btn rb360-btn-light" href="{{ $productUrl }}">ไปหน้าสินค้า</a>
                </div>
                <div style="margin-top:8px;color:rgba(255,255,255,.7);font-size:13px;">
                    @if ($reviewCount > 0)
                        รีวิวจากลูกค้า {{ number_format($reviewCount) }} รายการ
                    @else
                        พร้อมบริการหลังการขาย และช่องทางติดต่อครบ
                    @endif
                </div>
            </div>
        </section>

        <div class="rb360-footer">
            <div>© {{ date('Y') }} Rubyshop Co., Ltd.</div>
            <div class="rb360-policy-links">
                @foreach ($policyLinks as $policy)
                    <a href="{{ $policy['url'] }}">{{ $policy['label'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="rb360-sticky">
    <div class="rb360-sticky-row">
        <a class="rb360-sticky-call" href="tel:{{ $contactPhone }}">โทร {{ $contactPhoneDisplay }}</a>
        <a class="rb360-sticky-line" href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer">แชท LINE</a>
    </div>
</div>

@php
    $merchantReturnPolicySchema = [
        '@type' => 'MerchantReturnPolicy',
        'applicableCountry' => 'TH',
        'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
        'merchantReturnDays' => (int) theme_option('merchant_return_days', 7),
        'returnMethod' => 'https://schema.org/ReturnByMail',
        'returnFees' => 'https://schema.org/ReturnShippingFees',
    ];

    if ($merchantReturnPolicyUrl = theme_option('merchant_return_policy_url')) {
        $merchantReturnPolicySchema['merchantReturnLink'] = url($merchantReturnPolicyUrl);
    }

    $rb360OfferSchema = [
        '@type' => 'Offer',
        'priceCurrency' => 'THB',
        'price' => (float) ($salePrice ?: 0),
        'availability' => 'https://schema.org/InStock',
        'url' => $productUrl,
        'hasMerchantReturnPolicy' => $merchantReturnPolicySchema,
    ];

    $rb360ProductSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'image' => $gallery->map(fn ($image) => RvMedia::getImageUrl($image, 'origin', false, RvMedia::getDefaultImage()))->values()->all(),
        'description' => $safeDescription,
        'brand' => $product->brand?->name ? ['@type' => 'Brand', 'name' => $product->brand->name] : null,
        'sku' => $product->sku ?: null,
        'offers' => $rb360OfferSchema,
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($rb360ProductSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<script>
    (function () {
        var GA_MEASUREMENT_ID = 'G-WSR5H4YBF2';
        var ADS_CONVERSION_ID = 'AW-1065750118';
        var ADS_CONVERSION_LABEL = 'I36kCOmd4pQcEOacmPwD';

        function ensureGtag() {
            if (typeof window.gtag === 'function') {
                return;
            }
            window.dataLayer = window.dataLayer || [];
            window.gtag = function () { window.dataLayer.push(arguments); };

            var script = document.createElement('script');
            script.async = true;
            script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(GA_MEASUREMENT_ID);
            document.head.appendChild(script);

            window.gtag('js', new Date());
            window.gtag('config', GA_MEASUREMENT_ID);
            window.gtag('config', ADS_CONVERSION_ID);
        }

        function track(eventName, params) {
            if (typeof window.gtag !== 'function') {
                return;
            }
            window.gtag('event', eventName, params || {});
        }

        ensureGtag();

        document.addEventListener('click', function (event) {
            var target = event.target.closest('[data-ads-cta]');
            if (! target) return;

            track('landing_cta_click', {
                event_category: 'RB360 Landing',
                event_label: target.getAttribute('data-ads-cta'),
                page_path: window.location.pathname
            });
        });

        var form = document.getElementById('rb360LeadForm');
        if (!form) return;

        var submitBtn = document.getElementById('rb360LeadSubmit');
        var okBox = document.getElementById('rb360LeadOk');
        var errBox = document.getElementById('rb360LeadErr');
        var contentInput = document.getElementById('rb360LeadContent');
        var budgetInput = document.getElementById('lead_budget');
        var messageInput = document.getElementById('lead_message');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            if (okBox) okBox.style.display = 'none';
            if (errBox) errBox.style.display = 'none';

            var budget = budgetInput ? budgetInput.value : '';
            var message = messageInput ? messageInput.value : '';
            if (contentInput) {
                contentInput.value = [
                    'สินค้าที่สนใจ: RB-360',
                    budget ? ('งบประมาณ: ' + budget) : null,
                    message ? ('รายละเอียด: ' + message) : null,
                    'Landing URL: ' + window.location.href
                ].filter(Boolean).join('\n');
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'กำลังส่งข้อมูล...';
            }

            track('lead_form_submit_start', {
                event_category: 'RB360 Landing',
                event_label: 'rb360-lead-form'
            });

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form)
            })
                .then(function (response) {
                    return response.json().catch(function () { return {}; }).then(function (data) {
                        if (!response.ok || data.error) {
                            throw data;
                        }
                        return data;
                    });
                })
                .then(function () {
                    if (okBox) okBox.style.display = 'block';
                    form.reset();

                    track('generate_lead', {
                        event_category: 'RB360 Landing',
                        event_label: 'rb360-lead-form-success',
                        value: 1
                    });

                    track('conversion', {
                        send_to: ADS_CONVERSION_ID + '/' + ADS_CONVERSION_LABEL,
                        value: 1.0,
                        currency: 'THB'
                    });
                })
                .catch(function (error) {
                    if (errBox) {
                        var msg = 'ส่งข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง';
                        if (error && error.message) {
                            msg = error.message;
                        }
                        errBox.textContent = msg;
                        errBox.style.display = 'block';
                    }
                    track('lead_form_submit_error', {
                        event_category: 'RB360 Landing',
                        event_label: 'rb360-lead-form-error'
                    });
                })
                .finally(function () {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'ส่งข้อมูลขอราคา';
                    }
                });
        });
    })();
</script>

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(fn ($faq) => [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $faq['a'],
        ],
    ], $faqItems),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
