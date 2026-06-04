@php
    use Botble\Ecommerce\Facades\EcommerceHelper;
    use Botble\Ecommerce\Models\Customer;

    Theme::layout('full-width');

    $showPhone = (bool) get_ecommerce_setting('enabled_phone_field_in_registration_form', true);
    $phoneRequired = $showPhone && (EcommerceHelper::isLoginUsingPhone() || get_ecommerce_setting('make_customer_phone_number_required', false));
    $privacyPolicyUrl = Theme::termAndPrivacyPolicyUrl();
    $socialLoginHtml = trim((string) apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, Customer::class));
    $hasSocialLogin = $socialLoginHtml !== '';
    $showEmailForm = true;
    $brandLogo = theme_option('logo_light') ?: theme_option('logo');
@endphp

<style>
.ruby-auth-page {
    min-height: calc(100vh - 120px);
    background: linear-gradient(135deg, #fef2f2 0%, #f4f6fb 50%, #eef2f8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 32px 16px;
    box-sizing: border-box;
}
.ruby-auth-card {
    display: flex;
    width: 100%;
    max-width: 940px;
    min-height: 520px;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 24px 72px rgba(15,23,42,0.13), 0 4px 16px rgba(220,38,38,0.08);
}
/* Brand panel */
.ruby-brand-panel {
    width: 340px;
    flex-shrink: 0;
    background: linear-gradient(150deg, #dc2626 0%, #7f1d1d 100%);
    padding: 44px 36px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    color: #fff;
}
.ruby-brand-panel::before {
    content: '';
    position: absolute;
    top: -64px; right: -64px;
    width: 220px; height: 220px;
    border-radius: 50%;
    border: 40px solid rgba(255,255,255,0.07);
    pointer-events: none;
}
.ruby-brand-panel::after {
    content: '';
    position: absolute;
    bottom: -48px; left: -48px;
    width: 180px; height: 180px;
    border-radius: 50%;
    border: 32px solid rgba(255,255,255,0.06);
    pointer-events: none;
}
.ruby-brand-logo {
    display: flex;
    align-items: center;
    position: relative;
    z-index: 1;
}
.ruby-brand-logo img {
    height: 38px;
    width: auto;
    max-width: 160px;
    object-fit: contain;
    display: block;
}
.ruby-brand-body { position: relative; z-index: 1; }
.ruby-brand-headline {
    font-size: 20px;
    font-weight: 800;
    line-height: 1.35;
    letter-spacing: -0.01em;
    color: rgba(255,255,255,0.95);
    margin-top: 32px;
    margin-bottom: 20px !important;
}
.ruby-brand-features { display: flex; flex-direction: column; gap: 12px; }
.ruby-brand-feature {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: rgba(255,255,255,0.85);
}
.ruby-brand-feature-dot {
    width: 26px; height: 26px;
    background: rgba(255,255,255,0.14);
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    flex-shrink: 0;
}
.ruby-brand-footer {
    border-top: 1px solid rgba(255,255,255,0.15);
    padding-top: 22px;
    position: relative;
    z-index: 1;
}
.ruby-brand-footer p {
    color: rgba(255,255,255,0.7) !important;
    font-size: 12.5px;
    margin-bottom: 10px !important;
    line-height: 1.4 !important;
}
.ruby-brand-footer a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    border-radius: 999px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}
.ruby-brand-footer a:hover {
    background: rgba(255,255,255,0.25);
    color: #fff;
    text-decoration: none;
}
/* Form panel */
.ruby-form-panel {
    flex: 1;
    background: #fff;
    padding: 36px 44px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
/* Tabs */
.ruby-tabs {
    display: flex;
    background: #f3f4f6;
    border-radius: 10px;
    padding: 3px;
    margin-bottom: 20px;
    gap: 2px;
}
.ruby-tab {
    flex: 1;
    text-align: center;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.2s;
    cursor: default;
    display: block;
}
.ruby-tab.is-active {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 2px 8px rgba(220,38,38,0.25);
}
a.ruby-tab:hover:not(.is-active) {
    color: #dc2626;
    text-decoration: none;
}
/* Headings */
.ruby-form-title {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    letter-spacing: -0.02em;
    margin-bottom: 4px !important;
    line-height: 1.2;
}
.ruby-form-subtitle {
    color: #6b7280;
    font-size: 13px;
    margin-bottom: 18px !important;
    line-height: 1.5;
}
/* Alerts */
.ruby-alert {
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 13px;
    margin-bottom: 14px !important;
    line-height: 1.5;
}
.ruby-alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#16a34a; }
.ruby-alert-error   { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
/* Social */
.ruby-social-wrap { display: flex; flex-direction: column; gap: 10px; margin-bottom: 2px; }
.ruby-divider {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 14px 0;
    color: #9ca3af;
    font-size: 12px;
    font-weight: 500;
}
.ruby-divider::before,
.ruby-divider::after { content: ''; flex: 1; border-top: 1px solid #e5e7eb; }
/* Fields */
.ruby-field { display: flex; flex-direction: column; gap: 5px; }
.ruby-label { font-size: 13px; font-weight: 600; color: #374151; }
.ruby-input-wrap { position: relative; }
.ruby-input-icon {
    position: absolute;
    left: 13px; top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 13px;
    pointer-events: none;
    z-index: 1;
}
.ruby-input {
    display: block;
    width: 100%;
    min-height: 44px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 0 14px 0 38px;
    font-size: 14px;
    color: #111827;
    background: #fafafa;
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
    appearance: none;
    -webkit-appearance: none;
    box-sizing: border-box;
    font-family: inherit;
}
.ruby-input::placeholder { color: #9ca3af; }
.ruby-input:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
    background: #fff;
}
.ruby-input.has-toggle { padding-right: 42px; }
/* 2-column grid */
.ruby-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
/* Password toggle */
.ruby-pw-btn {
    position: absolute;
    right: 12px; top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 2px 4px;
    font-size: 14px;
    line-height: 1;
    display: flex;
    align-items: center;
    z-index: 1;
}
.ruby-pw-btn:hover { color: #6b7280; }
/* Terms checkbox */
.ruby-terms-row {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 13px;
    color: #4b5563;
    line-height: 1.5;
}
.ruby-terms-row input[type="checkbox"] {
    width: 15px !important; height: 15px !important;
    min-width: 15px !important; min-height: 15px !important;
    margin-top: 2px !important; margin-left: 0 !important;
    padding: 0 !important;
    appearance: auto !important; -webkit-appearance: checkbox !important;
    accent-color: #dc2626;
    transform: none !important; box-shadow: none !important;
    flex-shrink: 0;
}
.ruby-terms-row label { margin: 0 !important; }
.ruby-terms-row a { color: #dc2626; font-weight: 600; text-decoration: none; }
.ruby-terms-row a:hover { text-decoration: underline; }
/* Submit button */
.ruby-btn-primary {
    display: block; width: 100%;
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: #fff;
    font-weight: 700; font-size: 14.5px;
    border: none; border-radius: 10px;
    padding: 12px 16px;
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
    box-shadow: 0 4px 14px rgba(220,38,38,0.28);
    letter-spacing: 0.01em;
    font-family: inherit;
}
.ruby-btn-primary:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(220,38,38,0.34);
}
.ruby-btn-primary:active { transform: translateY(0); opacity: 1; }
/* Bottom link */
.ruby-auth-bottom {
    text-align: center;
    font-size: 13px;
    color: #6b7280;
    margin-top: 16px !important;
}
.ruby-auth-bottom a { color: #dc2626; font-weight: 600; text-decoration: none; }
.ruby-auth-bottom a:hover { text-decoration: underline; }
/* Mobile */
@media (max-width: 767px) {
    .ruby-auth-page {
        padding: 0;
        align-items: flex-start;
        min-height: auto;
        background: #fff;
    }
    .ruby-auth-card {
        flex-direction: column;
        border-radius: 0;
        box-shadow: none;
        min-height: auto;
        max-width: 100%;
    }
    .ruby-brand-panel {
        display: none !important;
    }
    .ruby-brand-panel::before,
    .ruby-brand-panel::after { display: none; }
    .ruby-brand-body,
    .ruby-brand-footer { display: none !important; }
    .ruby-form-panel { padding: 24px 20px 32px; }
    .ruby-form-title { font-size: 20px; }
    .ruby-form-grid { grid-template-columns: 1fr; }
}
</style>

<div class="ruby-auth-page">
    <div class="ruby-auth-card">

        {{-- Brand Panel --}}
        <div class="ruby-brand-panel">
            <div class="ruby-brand-logo">
                @if ($brandLogo)
                    <img src="{{ RvMedia::getImageUrl($brandLogo) }}" alt="{{ theme_option('site_title') }}">
                @else
                    <span style="font-size:21px;font-weight:900;letter-spacing:-0.03em;color:#fff">RUBYSHOP</span>
                @endif
            </div>

            <div class="ruby-brand-body">
                <p class="ruby-brand-headline">เข้าร่วม RUBYSHOP<br>วันนี้</p>
                <div class="ruby-brand-features">
                    <div class="ruby-brand-feature">
                        <div class="ruby-brand-feature-dot"><i class="fas fa-box"></i></div>
                        <span>ติดตามคำสั่งซื้อทั้งหมด</span>
                    </div>
                    <div class="ruby-brand-feature">
                        <div class="ruby-brand-feature-dot"><i class="fas fa-shield-alt"></i></div>
                        <span>จัดการการรับประกันสินค้า</span>
                    </div>
                    <div class="ruby-brand-feature">
                        <div class="ruby-brand-feature-dot"><i class="fas fa-tag"></i></div>
                        <span>รับข้อเสนอพิเศษสำหรับสมาชิก</span>
                    </div>
                </div>
            </div>

            <div class="ruby-brand-footer">
                <p>{{ __('มีบัญชีอยู่แล้ว?') }}</p>
                <a href="{{ route('customer.login') }}">
                    {{ __('เข้าสู่ระบบ') }}
                    <i class="fas fa-arrow-right" style="font-size:10px"></i>
                </a>
            </div>
        </div>

        {{-- Form Panel --}}
        <div class="ruby-form-panel">

            @if (session('success_msg'))
                <div class="ruby-alert ruby-alert-success">{{ session('success_msg') }}</div>
            @endif
            @if (session('error_msg'))
                <div class="ruby-alert ruby-alert-error">{{ session('error_msg') }}</div>
            @endif
            @if ($errors->any())
                <div class="ruby-alert ruby-alert-error">
                    <ul style="margin:0;padding-left:16px;display:flex;flex-direction:column;gap:3px">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="ruby-tabs">
                <a href="{{ route('customer.login') }}" class="ruby-tab">{{ __('Sign in') }}</a>
                <span class="ruby-tab is-active">{{ __('Sign up') }}</span>
            </div>

            <p class="ruby-form-title">{{ __('สมัครสมาชิก') }}</p>
            <p class="ruby-form-subtitle">{{ __('เข้าร่วม RUBYSHOP เพื่อจัดการคำสั่งซื้อ ติดตามการรับประกัน และรับข้อเสนอเฉพาะสมาชิก') }}</p>

            @if ($hasSocialLogin)
                <div class="ruby-social-wrap">{!! $socialLoginHtml !!}</div>
                <div class="ruby-divider">{{ __('หรือ') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.register.post') }}" style="display:flex;flex-direction:column;gap:12px">
                @csrf

                {{-- Name + Phone (2-col if phone enabled, else full-width name) --}}
                @if ($showPhone)
                    <div class="ruby-form-grid">
                        <div class="ruby-field">
                            <label class="ruby-label" for="name-field">{{ __('Full name') }}</label>
                            <div class="ruby-input-wrap">
                                <i class="ruby-input-icon fas fa-user"></i>
                                <input id="name-field" type="text" name="name"
                                    value="{{ old('name') }}"
                                    placeholder="{{ __('Your full name') }}"
                                    autocomplete="name"
                                    class="ruby-input" required>
                            </div>
                        </div>
                        <div class="ruby-field">
                            <label class="ruby-label" for="phone-field">
                                {{ $phoneRequired ? __('Phone number') : __('Phone (optional)') }}
                            </label>
                            <div class="ruby-input-wrap">
                                <i class="ruby-input-icon fas fa-phone"></i>
                                <input id="phone-field" type="tel" name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="08X-XXX-XXXX"
                                    autocomplete="tel"
                                    class="ruby-input"
                                    {{ $phoneRequired ? 'required' : '' }}>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="ruby-field">
                        <label class="ruby-label" for="name-field">{{ __('Full name') }}</label>
                        <div class="ruby-input-wrap">
                            <i class="ruby-input-icon fas fa-user"></i>
                            <input id="name-field" type="text" name="name"
                                value="{{ old('name') }}"
                                placeholder="{{ __('Your full name') }}"
                                autocomplete="name"
                                class="ruby-input" required>
                        </div>
                    </div>
                @endif

                {{-- Email --}}
                <div class="ruby-field">
                    <label class="ruby-label" for="email-field">
                        {{ EcommerceHelper::isLoginUsingPhone() ? __('Email (optional)') : __('Email address') }}
                    </label>
                    <div class="ruby-input-wrap">
                        <i class="ruby-input-icon fas fa-envelope"></i>
                        <input id="email-field" type="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="name@company.com"
                            autocomplete="email"
                            class="ruby-input"
                            {{ EcommerceHelper::isLoginUsingPhone() ? '' : 'required' }}>
                    </div>
                </div>

                {{-- Password + Confirm (2-col) --}}
                <div class="ruby-form-grid">
                    <div class="ruby-field">
                        <label class="ruby-label" for="password-field">{{ __('Password') }}</label>
                        <div class="ruby-input-wrap">
                            <i class="ruby-input-icon fas fa-lock"></i>
                            <input type="password" id="password-field" name="password"
                                placeholder="{{ __('Secure password') }}"
                                autocomplete="new-password"
                                class="ruby-input has-toggle" required>
                            <button type="button" class="ruby-pw-btn"
                                onclick="rubyTogglePw('password-field',this)"
                                aria-label="{{ __('Toggle password') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="ruby-field">
                        <label class="ruby-label" for="password-confirm-field">{{ __('Confirm password') }}</label>
                        <div class="ruby-input-wrap">
                            <i class="ruby-input-icon fas fa-lock"></i>
                            <input type="password" id="password-confirm-field" name="password_confirmation"
                                placeholder="{{ __('Re-enter password') }}"
                                autocomplete="new-password"
                                class="ruby-input has-toggle" required>
                            <button type="button" class="ruby-pw-btn"
                                onclick="rubyTogglePw('password-confirm-field',this)"
                                aria-label="{{ __('Toggle password') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="ruby-terms-row">
                    <input type="checkbox" id="agree" name="agree_terms_and_policy" value="1"
                        {{ old('agree_terms_and_policy') ? 'checked' : '' }} required>
                    <label for="agree">
                        @if ($privacyPolicyUrl)
                            {!! __('I agree to the :link', ['link' => '<a href="' . $privacyPolicyUrl . '" target="_blank">' . __('Terms and Privacy Policy') . '</a>']) !!}
                        @else
                            {{ __('I agree to the Terms and Privacy Policy') }}
                        @endif
                    </label>
                </div>

                <button type="submit" class="ruby-btn-primary">{{ __('Create account') }}</button>
            </form>

            <p class="ruby-auth-bottom">
                {{ __('Already have an account?') }}
                <a href="{{ route('customer.login') }}">{{ __('Sign in') }}</a>
            </p>
        </div>

    </div>
</div>

<script>
function rubyTogglePw(id, btn) {
    var el = document.getElementById(id);
    var icon = btn.querySelector('i');
    if (el.type === 'password') {
        el.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        el.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
