@if (Route::has('customer.google.login'))
    <a href="{{ route('customer.google.login') }}"
        class="flex items-center justify-center gap-3 rounded-2xl border border-gray-200 px-4 py-3 text-gray-700 hover:border-red-400 hover:text-red-500 transition w-full bg-white">
        <img src="https://www.rubyshop.co.th/storage/logo/g-icon.png" alt="Google"
            class="h-5 w-5 object-contain" loading="lazy" decoding="async" />
        <span class="font-semibold">{{ __('Continue with Google') }}</span>
    </a>
@endif
