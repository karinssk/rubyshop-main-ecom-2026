@php
    use Botble\Ecommerce\Facades\EcommerceHelper;
    use Botble\Ecommerce\Models\Customer;

    Theme::layout('full-width');

    $loginOption = EcommerceHelper::getLoginOption();
    $socialLoginHtml = trim((string) apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, Customer::class));
    $hasSocialLogin = $socialLoginHtml !== '';
    $showEmailForm = ! $hasSocialLogin || $errors->any() || old('email');
    $loginLabel = __('Email address');
    $loginPlaceholder = __('name@company.com');
    $loginType = 'email';

    if ($loginOption === 'phone') {
        $loginLabel = __('Phone number');
        $loginPlaceholder = __('08X-XXX-XXXX');
        $loginType = 'tel';
    } elseif ($loginOption === 'email_or_phone') {
        $loginLabel = __('Email or phone');
        $loginPlaceholder = __('name@company.com / 08X-XXX-XXXX');
        $loginType = 'text';
    }
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
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl px-8 py-10">
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
            <h1 class="text-3xl font-semibold text-gray-900">{{ __('ยินดีต้อนรับสู่ RUBYSHOP') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('เข้าสู่ระบบเพื่อดำเนินการต่อไปยังบัญชีของคุณ') }}</p>
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
                            src="https://www.rubyshop.co.th/storage/logo/png-clipart-gmail-icon-gmail-email-logo-g-suite-google-gmail-angle-text-thumbnail.png"
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

        <form method="POST" action="{{ route('customer.login.post') }}" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700" for="login-field">{{ $loginLabel }}</label>
                <input
                    type="{{ $loginType }}"
                    id="login-field"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="{{ $loginPlaceholder }}"
                    autocomplete="username"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-red-400 focus:ring-2 focus:ring-red-100 transition"
                    required
                >
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between text-sm font-medium text-gray-700">
                    <label for="password-field">{{ __('Password') }}</label>
                    <a href="{{ route('customer.password.reset') }}" class="text-red-500 hover:text-red-600">
                        {{ __('Forgot password?') }}
                    </a>
                </div>
                <input
                    type="password"
                    id="password-field"
                    name="password"
                    placeholder="{{ __('Enter your password') }}"
                    autocomplete="current-password"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-red-400 focus:ring-2 focus:ring-red-100 transition"
                    required
                >
            </div>

            <div class="flex items-center gap-2 text-sm text-gray-600">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    value="1"
                    class="h-4 w-4 rounded border-gray-300 text-red-500 focus:ring-red-400"
                    {{ old('remember', true) ? 'checked' : '' }}
                >
                <label for="remember">{{ __('Remember me for 30 days') }}</label>
            </div>

            <button type="submit" class="w-full bg-red-500 text-white font-semibold py-3 rounded-2xl hover:bg-red-600 transition shadow-md shadow-red-200">
                {{ __('Sign in') }}
            </button>
        </form>

        @if ($hasSocialLogin)
                </div>
            </details>
        @endif

        <p class="text-center text-sm text-gray-600 mt-8">
            {{ __("Don't have an account?") }}
            <a href="{{ route('customer.register') }}" class="text-red-500 font-semibold hover:text-red-600">
                {{ __('Sign up') }}
            </a>
        </p>
    </div>
</div>
