@php
    use Botble\Ecommerce\Facades\EcommerceHelper;
    use Botble\Ecommerce\Models\Customer;

    Theme::layout('full-width');

    $showPhone = (bool) get_ecommerce_setting('enabled_phone_field_in_registration_form', true);
    $phoneRequired = $showPhone && (EcommerceHelper::isLoginUsingPhone() || get_ecommerce_setting('make_customer_phone_number_required', false));
    $privacyPolicyUrl = Theme::termAndPrivacyPolicyUrl();
    $socialLoginHtml = trim((string) apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, Customer::class));
    $hasSocialLogin = $socialLoginHtml !== '';
    $showEmailForm = ! $hasSocialLogin || $errors->any() || old('name') || old('email') || old('phone');
@endphp

<style>
    .auth-email-toggle summary {
        list-style: none;
    }

    .auth-email-toggle summary::-webkit-details-marker {
        display: none;
    }
</style>

<div class="min-h-[80vh] bg-[#f5f7fb] flex items-center justify-center py-16 px-4 sm:px-8">
    <div class="w-full max-w-xl bg-white rounded-3xl shadow-xl px-8 py-10">
        @if (session('success_msg'))
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success_msg') }}
            </div>
        @endif

        @if (session('error_msg'))
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error_msg') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="text-center mb-8">
            <h1 class="text-3xl font-semibold text-gray-900">{{ __('สมัครสมาชิก') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('เข้าร่วม RUBYSHOP เพื่อจัดการคำสั่งซื้อ ติดตามการรับประกัน และรับข้อเสนอเฉพาะสมาชิก') }}</p>
        </div>

        @if ($hasSocialLogin)
            <div class="space-y-3">
                {!! $socialLoginHtml !!}
            </div>

            <div class="flex items-center gap-4 text-sm text-gray-400 mt-8">
                <span class="flex-1 border-t border-gray-200"></span>
                <span>{{ __('or') }}</span>
                <span class="flex-1 border-t border-gray-200"></span>
            </div>

            <details class="auth-email-toggle mt-6 rounded-2xl border border-gray-200 bg-gray-50" {{ $showEmailForm ? 'open' : '' }}>
                <summary class="flex cursor-pointer items-center justify-between gap-4 px-5 py-4 text-sm font-semibold text-gray-800 hover:text-red-500 transition">
                    <span class="flex items-center gap-3">
                        <img
                            src="https://www.rubyshop.co.th/storage/logo/gmail-logo-201003176.webp"
                            alt="Email"
                            class="h-5 w-5 object-contain"
                            loading="lazy"
                            decoding="async"
                        />
                        <span>{{ __('Continue with email') }}</span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.167l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                    </svg>
                </summary>

                <div class="border-t border-gray-200 px-5 py-5">
        @endif

        <form method="POST" action="{{ route('customer.register.post') }}" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700" for="name-field">{{ __('Full name') }}</label>
                <input
                    id="name-field"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="{{ __('Your full name') }}"
                    autocomplete="name"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-red-400 focus:ring-2 focus:ring-red-100 transition"
                    required
                >
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700" for="email-field">
                    {{ EcommerceHelper::isLoginUsingPhone() ? __('Email (optional)') : __('Email address') }}
                </label>
                <input
                    id="email-field"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="name@company.com"
                    autocomplete="email"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-red-400 focus:ring-2 focus:ring-red-100 transition"
                    {{ EcommerceHelper::isLoginUsingPhone() ? '' : 'required' }}
                >
            </div>

            @if ($showPhone)
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700" for="phone-field">
                        {{ $phoneRequired ? __('Phone number') : __('Phone (optional)') }}
                    </label>
                    <input
                        id="phone-field"
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="08X-XXX-XXXX"
                        autocomplete="tel"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-red-400 focus:ring-2 focus:ring-red-100 transition"
                        {{ $phoneRequired ? 'required' : '' }}
                    >
                </div>
            @endif

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700" for="password-field">{{ __('Password') }}</label>
                <input
                    id="password-field"
                    type="password"
                    name="password"
                    placeholder="{{ __('Enter a secure password') }}"
                    autocomplete="new-password"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-red-400 focus:ring-2 focus:ring-red-100 transition"
                    required
                >
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700" for="password-confirm-field">{{ __('Confirm password') }}</label>
                <input
                    id="password-confirm-field"
                    type="password"
                    name="password_confirmation"
                    placeholder="{{ __('Re-enter your password') }}"
                    autocomplete="new-password"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-red-400 focus:ring-2 focus:ring-red-100 transition"
                    required
                >
            </div>

            <div class="flex items-start gap-3 text-sm text-gray-600">
                <input
                    type="checkbox"
                    id="agree"
                    name="agree_terms_and_policy"
                    value="1"
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-red-500 focus:ring-red-400"
                    {{ old('agree_terms_and_policy') ? 'checked' : '' }}
                    required
                >
                <label for="agree">
                    @if ($privacyPolicyUrl)
                        {!! __('I agree to the :link', ['link' => '<a href="' . $privacyPolicyUrl . '" target="_blank" class="text-red-500 font-semibold hover:text-red-600">' . __('Terms and Privacy Policy') . '</a>']) !!}
                    @else
                        {{ __('I agree to the Terms and Privacy Policy') }}
                    @endif
                </label>
            </div>

            <button type="submit" class="w-full bg-red-500 text-white font-semibold py-3 rounded-2xl hover:bg-red-600 transition shadow-md shadow-red-200">
                {{ __('Create account') }}
            </button>
        </form>

        @if ($hasSocialLogin)
                </div>
            </details>
        @endif

        <p class="text-center text-sm text-gray-600 mt-8">
            {{ __('Already have an account?') }}
            <a href="{{ route('customer.login') }}" class="text-red-500 font-semibold hover:text-red-600">
                {{ __('Sign in') }}
            </a>
        </p>
    </div>
</div>
