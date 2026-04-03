<style>
    #contact p {
        margin-bottom: 0.5rem !important;
        line-height: 1.6;
    }
</style>

<section id="contact" class="bg-gradient-to-b from-white to-gray-50 pt-10 lg:pt-12 pb-16 lg:pb-20">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <div class="flex justify-center mb-5">
                <img src="https://www.rubyshop.co.th/storage/logo/rubyshop-no-bg-250pxx100px.jpg" alt="RUBYSHOP" class="h-12 md:h-16 object-contain">
            </div>
            <p class="uppercase tracking-[0.3em] text-xs text-red-500 font-semibold mb-3">{{ __('Rubyshop Contact') }}</p>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4">
                {{ __('เชื่อมต่อกับ RUBYSHOP ได้ทุกช่องทาง') }}
            </h2>
            <p class="text-gray-600 text-base lg:text-lg leading-relaxed">
                {{ __('ทีมงานของเราพร้อมช่วยเหลือคุณในทุกขั้นตอน ทั้งการให้ข้อมูลสินค้า การสาธิต และบริการหลังการขายทั่วประเทศ') }}
            </p>
        </div>

        <div class="mt-12 grid gap-10 lg:grid-cols-2">
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
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3872.8052475266736!2d100.5745573!3d13.9105861!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2838a1d8ed6f5%3A0x71b9b36c507a601e!2zUlVCWVNIT1AgV0FSRUhPVVNFICjguKvguIjguIEu4Lij4Li54Lia4Li14LmJ4LiK4LmK4Lit4LibKQ!5e0!3m2!1sen!2sth!4v1756979537888!5m2!1sen!2sth"
                        width="100%"
                        height="280"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-3xl shadow-2xl p-8">
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

        <div class="mt-16 grid gap-6 md:grid-cols-3">
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
                    successMessage.classList.add('hidden');
                } else {
                    successMessage.textContent = data.message;
                    successMessage.classList.remove('hidden');
                    errorMessage.classList.add('hidden');
                    contactForm.reset();
                    successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;

                errorMessage.textContent = '{{ __('เกิดข้อผิดพลาด โปรดลองอีกครั้ง') }}';
                errorMessage.classList.remove('hidden');
                successMessage.classList.add('hidden');
            });
        });
    });
</script>
