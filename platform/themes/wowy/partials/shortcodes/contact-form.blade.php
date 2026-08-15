<style>
    #contact {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        background: linear-gradient(180deg, #fff 0%, #f9fafb 100%);
        padding: 40px 0 64px;
        max-width: 100vw;
        overflow-x: hidden;
    }

    #contact p {
        margin-bottom: 0.5rem !important;
        line-height: 1.6;
    }

    #contact h2,
    #contact h3,
    #contact a,
    #contact p {
        max-width: 100%;
        overflow-wrap: anywhere;
    }

    #contact > div {
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 0 16px;
        box-sizing: border-box;
    }

    #contact .mt-12 {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 48px;
        margin-top: 48px;
    }

    #contact .space-y-6 > * + * {
        margin-top: 32px;
    }

    #contact .bg-white {
        background: #fff;
    }

    #contact .rounded-3xl {
        border-radius: 24px;
    }

    #contact .rounded-2xl {
        border-radius: 16px;
    }

    #contact .border {
        border: 1px solid #f0f0f0 !important;
    }

    #contact .shadow,
    #contact .shadow-lg,
    #contact .shadow-2xl {
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    #contact .p-8 {
        padding: 32px;
    }

    #contact .p-6 {
        padding: 24px;
    }

    #contact .p-5 {
        padding: 20px;
    }

    #contact ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    #contact li.flex,
    #contact .flex {
        display: flex;
    }

    #contact .items-start {
        align-items: flex-start;
    }

    #contact .items-center {
        align-items: center;
    }

    #contact .justify-center {
        justify-content: center;
    }

    #contact .gap-4 {
        gap: 16px;
    }

    #contact .gap-3 {
        gap: 12px;
    }

    #contact .grid {
        display: grid;
    }

    #contact .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    #contact .md\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    #contact .gap-6 {
        gap: 32px;
    }

    #contact .gap-4 {
        gap: 20px;
    }

    #contact .mt-16.grid {
        gap: 36px;
    }

    #contact .contact-map-image {
        display: block;
        width: 100%;
        height: 320px;
        min-height: 320px;
        object-fit: cover;
        background: #f3f4f6;
    }

    #contact .contact-map-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 14px 18px 18px;
        color: #dc2626;
        font-weight: 700;
        text-decoration: none;
    }

    #contact .contact-map-link:hover {
        color: #991b1b;
        text-decoration: underline;
    }

    #contact input,
    #contact textarea {
        width: 100%;
        min-height: 48px;
        padding: 12px 16px;
        border: 1px solid #e5e7eb !important;
        border-radius: 16px;
        background: #fff;
        color: #111827;
    }

    #contact textarea {
        min-height: 132px;
        resize: vertical;
    }

    #contact input:focus,
    #contact textarea:focus {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
        outline: none;
    }

    #contact label {
        display: block;
        margin-bottom: 4px;
        color: #374151;
        font-size: 0.875rem;
        font-weight: 500;
    }

    #contact button[type="submit"] {
        display: inline-flex;
        width: 100%;
        min-height: 48px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 16px;
        background: #dc2626;
        color: #fff;
        font-weight: 600;
        box-shadow: 0 12px 24px rgba(220, 38, 38, 0.18);
    }

    #contact .contact-message {
        display: none;
        padding: 16px;
        border-radius: 16px;
        font-size: 0.875rem;
    }

    #contact .contact-success-message {
        color: #047857;
        background: #d1fae5;
    }

    #contact .contact-error-message {
        color: #b91c1c;
        background: #fee2e2;
    }

    #contact .hidden {
        display: none !important;
    }

    #contact .contact-form-card {
        align-self: start;
    }

    #contact .contact-support-grid {
        margin-top: 52px;
    }

    @media (max-width: 1199px) {
        #contact .mt-12 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        #contact {
            padding: 32px 0 48px;
        }

        #contact .p-8 {
            padding: 22px;
        }

        #contact h2 {
            max-width: 280px;
            margin-left: auto;
            margin-right: auto;
            font-size: 1.35rem;
            line-height: 1.3;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        #contact .text-center p {
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
            font-size: 0.95rem;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        #contact .mt-12,
        #contact .contact-support-grid {
            width: 100%;
            max-width: 100%;
        }

        #contact .md\:grid-cols-2,
        #contact .md\:grid-cols-3 {
            grid-template-columns: 1fr;
        }

        #contact .mt-16 {
            margin-top: 40px;
        }

        #contact .contact-support-grid {
            margin-top: 40px;
        }
    }
</style>

<section id="contact" class="bg-gradient-to-b from-white to-gray-50 pt-10 lg:pt-12 pb-16 lg:pb-20">
    <div class="w-full px-4 sm:px-6 lg:px-12 2xl:px-16">
        <div class="w-full text-center">
            <div class="flex justify-center mb-5">
                <img src="https://www.rubyshop.co.th/storage/logo/rubyshop-no-bg-250pxx100px.jpg" alt="RUBYSHOP" width="250" height="100" loading="lazy" decoding="async" class="h-12 md:h-16 object-contain">
            </div>
            <p class="uppercase tracking-[0.3em] text-xs text-red-500 font-semibold mb-3">{{ __('Rubyshop Contact') }}</p>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4">
                {{ __('เชื่อมต่อกับ RUBYSHOP ได้ทุกช่องทาง') }}
            </h2>
            <p class="text-gray-600 text-base lg:text-lg leading-relaxed">
                {{ __('ทีมงานของเราพร้อมช่วยเหลือคุณในทุกขั้นตอน ทั้งการให้ข้อมูลสินค้า การสาธิต และบริการหลังการขายทั่วประเทศ') }}
            </p>
        </div>

        <div class="mt-12 grid gap-10 xl:grid-cols-2">
            <div class="space-y-6">
                <div class="bg-white border border-gray-100 rounded-3xl shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('ข้อมูลการติดต่อ') }}</h3>
                    <ul class="space-y-5 text-sm text-gray-600">
                        <li class="flex items-start gap-4">
                            <span class="w-10 h-10 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <div>
                                <p class="text-gray-900 font-medium mb-1">{{ __('สำนักงานใหญ่') }}</p>
                                <a href="https://maps.app.goo.gl/j61AcMSir21ZsMMD8" class="hover:text-red-600 hover:underline">
                                    97/60 โกสุมรวมใจ ซ. 39 แขวงดอนเมือง ดอนเมือง กรุงเทพมหานคร 10210
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-10 h-10 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt"></i>
                            </span>
                            <div>
                                <p class="text-gray-900 font-medium mb-1">{{ __('สายด่วนบริการลูกค้า') }}</p>
                                <a href="tel:0896667802" class="font-semibold text-gray-900 hover:text-red-600 hover:underline">089-666-7802</a>
                                <p class="text-xs text-gray-500 mt-1">{{ __('เปิดทำการ จันทร์-เสาร์ 08:30-17:30 น.') }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-10 h-10 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-line"></i>
                            </span>
                            <div>
                                <p class="text-gray-900 font-medium mb-1">LINE Official</p>
                                <a href="https://page.line.me/rubyshop168?openQrModal=true" class="hover:text-red-600 hover:underline">@rubyshop168</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-10 h-10 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <div>
                                <p class="text-gray-900 font-medium mb-1">{{ __('อีเมลฝ่ายบริการลูกค้า') }}</p>
                                <a href="mailto:saleruby.benjavan@gmail.com" class="hover:text-red-600 hover:underline">saleruby.benjavan@gmail.com</a>
                            </div>
                        </li>
                    </ul>

                    <div class="mt-8 flex items-center gap-4">
                        <span class="text-gray-500 text-sm">{{ __('ติดตามเรา') }}</span>
                        <div class="flex gap-3 text-lg">
                            <a href="https://www.facebook.com/rubyshopcoth" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-white hover:bg-blue-600 transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.youtube.com/channel/UCxiaZiIC8qs2C228jwIjcHg" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-white hover:bg-red-600 transition">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="https://www.instagram.com/rubyshop_168/" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-white hover:bg-pink-500 transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow">
                        <p class="text-xs uppercase text-gray-400 tracking-widest mb-2">{{ __('บริการครอบคลุมทั่วไทย') }}</p>
                        <p class="text-2xl font-bold text-gray-900">77 {{ __('จังหวัด') }}</p>
                        <p class="text-gray-500 text-sm mt-1">{{ __('ส่งด่วนและมีทีมบริการหลังการขายครบถ้วน') }}</p>
                    </div>
                    <div class=" rounded-2xl p-5 text-white shadow-lg">
                        <p class="text-xs uppercase tracking-[0.3em] mb-2">{{ __('HOTLINE') }}</p>
                          <a href="tel:0896667802"  class="hover:underline"><span class="text-2xl font-bold text-black">089-666-7802</span></a>
                        <p class="text-sm mt-1 opacity-90">{{ __('พร้อมให้คำปรึกษาและนัดสาธิตการใช้งาน') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow">
                    <img
                        class="contact-map-image"
                        src="{{ asset('storage/contact-map/rubyshop-office-map.webp') }}"
                        alt="{{ __('แผนที่สำนักงานใหญ่ RUBYSHOP ดอนเมือง กรุงเทพมหานคร') }}"
                        width="1024"
                        height="512"
                        loading="lazy"
                        decoding="async">
                    <a class="contact-map-link" href="https://maps.app.goo.gl/j61AcMSir21ZsMMD8" target="_blank" rel="noopener">
                        <i class="fas fa-map-marked-alt"></i>
                        {{ __('เปิดแผนที่ / นำทาง') }}
                    </a>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-3xl shadow-2xl p-8 contact-form-card">
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ __('กรอกข้อมูลเพื่อให้เราติดต่อกลับ') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('กรุณากรอกข้อมูลให้ครบถ้วน ทีมงานจะติดต่อกลับภายใน 1 วันทำการ') }}</p>

                {!! Form::open(['route' => 'public.send.contact', 'class' => 'space-y-4 contact-form', 'method' => 'POST', 'id' => 'contactFormForContact']) !!}
                    {!! apply_filters('pre_contact_form', null) !!}

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('ชื่อ-นามสกุล') }} *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('เบอร์โทรศัพท์') }} *</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('อีเมล') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">{{ __('หัวข้อ') }}</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
                        </div>
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">{{ __('รายละเอียดเพิ่มเติม') }}</label>
                        <textarea id="content" name="content" rows="5"
                                  class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">{{ old('content') }}</textarea>
                    </div>

                    {!! apply_filters('after_contact_form', null) !!}

                    <div>
                        {!! apply_filters('form_extra_fields_render', null, \Botble\Contact\Forms\Fronts\ContactForm::class) !!}
                    </div>

                    <div class="space-y-3">
                        <div id="contactSuccessAlertForContact" class="contact-message contact-success-message hidden p-4 text-sm text-green-700 bg-green-100 rounded-2xl"></div>
                        <div class="contact-message contact-error-message hidden p-4 text-sm text-red-700 bg-red-100 rounded-2xl"></div>
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane text-sm"></i>
                        {{ __('ส่งข้อความถึงทีมงาน') }}
                    </button>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="mt-16 grid gap-6 md:grid-cols-3 contact-support-grid">
            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ __('ขอใบเสนอราคา/สาธิตสินค้า') }}</h4>
                <p class="text-sm text-gray-600 mb-4">{{ __('กรอกความต้องการของคุณ เราจะจัดสเปกและนัดทีมช่างให้โดยด่วนที่สุด') }}</p>
                <span class="inline-flex items-center text-red-600 font-semibold text-sm">
                    {{ __('รับเรื่องภายใน 1 ชม.') }}
                </span>
            </div>
            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ __('ศูนย์บริการหลังการขาย') }}</h4>
                <p class="text-sm text-gray-600 mb-4">{{ __('ตรวจเช็ค ซ่อมบำรุง และรับประกันผลงานโดยทีมช่างเฉพาะทางของ RUBYSHOP') }}</p>
                <span class="inline-flex items-center text-red-600 font-semibold text-sm">
                    {{ __('อะไหล่แท้พร้อมบริการครบวงจร') }}
                </span>
            </div>
            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ __('ทีมช่าง / technician') }}</h4>
                <p class="text-sm text-gray-600 mb-4">{{ __('ปรึกษาปัญหาการใข้งาน') }}</p>
                <span class="inline-flex items-center text-red-600 font-semibold text-sm">
                    {{ __('ทีมช่าง พร้อมดูแล') }}
                </span>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactFormForContact');

        if (!contactForm) {
            return;
        }

        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const formData = new FormData(contactForm);
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const successMessage = contactForm.querySelector('.contact-success-message');
            const errorMessage = contactForm.querySelector('.contact-error-message');

            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i> {{ __('กำลังส่ง...') }}';

            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;

                if (data.error) {
                    errorMessage.textContent = data.message;
                    errorMessage.classList.remove('hidden');
                    errorMessage.style.display = 'block';
                    successMessage.classList.add('hidden');
                    successMessage.style.display = 'none';
                } else {
                    successMessage.textContent = data.message;
                    successMessage.classList.remove('hidden');
                    successMessage.style.display = 'block';
                    errorMessage.classList.add('hidden');
                    errorMessage.style.display = 'none';
                    contactForm.reset();
                    successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;

                errorMessage.textContent = '{{ __('เกิดข้อผิดพลาด โปรดลองอีกครั้ง') }}';
                errorMessage.classList.remove('hidden');
                errorMessage.style.display = 'block';
                successMessage.classList.add('hidden');
                successMessage.style.display = 'none';
            });
        });
    });
</script>
