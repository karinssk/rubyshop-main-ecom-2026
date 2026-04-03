<?php

namespace Botble\Ecommerce\Http\Controllers\Customers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Enums\CustomerStatusEnum;
use Botble\Ecommerce\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleLoginController extends BaseController
{
    public function redirect(): RedirectResponse
    {
        $clientId = $this->getClientId();
        $clientSecret = $this->getClientSecret();

        if (! $clientId || ! $clientSecret) {
            return $this->redirectWithError(__('Google login is not configured. Please contact support.'));
        }

        $state = Str::random(40);
        session(['google_state' => $state]);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $this->getRedirectUri(),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    public function callback(Request $request): RedirectResponse
    {
        if ($request->has('error')) {
            Log::warning('Google login error', ['error' => $request->input('error')]);

            return $this->redirectWithError(__('Unable to login with Google. Please try again.'));
        }

        $storedState = session('google_state');
        session()->forget('google_state');

        if (! $storedState || $storedState !== $request->input('state')) {
            return $this->redirectWithError(__('Invalid Google login session. Please try again.'));
        }

        $code = $request->input('code');

        if (! $code) {
            return $this->redirectWithError(__('Missing authorization code from Google.'));
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'redirect_uri' => $this->getRedirectUri(),
            'code' => $code,
        ]);

        if ($tokenResponse->failed()) {
            Log::error('Failed to get access token from Google', ['response' => $tokenResponse->json()]);

            return $this->redirectWithError(__('Failed to connect to Google. Please try again.'));
        }

        $accessToken = Arr::get($tokenResponse->json(), 'access_token');

        if (! $accessToken) {
            Log::error('Google login missing access token', ['response' => $tokenResponse->json()]);

            return $this->redirectWithError(__('Unable to login with Google at this time.'));
        }

        $userResponse = Http::withToken($accessToken)
            ->withHeaders(['Accept' => 'application/json'])
            ->get('https://www.googleapis.com/oauth2/v2/userinfo');

        if ($userResponse->failed()) {
            Log::error('Failed to fetch Google user info', ['response' => $userResponse->json()]);

            return $this->redirectWithError(__('Unable to fetch your Google profile. Please try again.'));
        }

        $profile = $userResponse->json();

        if (! Arr::get($profile, 'id')) {
            Log::error('Google profile missing ID', ['profile' => $profile]);

            return $this->redirectWithError(__('Google did not return the required information.'));
        }

        $customer = $this->findOrCreateCustomer($profile);

        Auth::guard('customer')->login($customer, true);

        return redirect()->intended(route('customer.overview'));
    }

    protected function findOrCreateCustomer(array $profile): Customer
    {
        $googleId = Arr::get($profile, 'id');

        $customer = Customer::query()->where('google_id', $googleId)->first();

        if (! $customer && $email = Arr::get($profile, 'email')) {
            $customer = Customer::query()->where('email', $email)->first();
        }

        if ($customer) {
            $customer->forceFill([
                'google_id' => $customer->google_id ?: $googleId,
                'google_avatar' => Arr::get($profile, 'picture') ?: $customer->google_avatar,
            ]);

            if (! $customer->confirmed_at) {
                $customer->confirmed_at = Carbon::now();
            }

            $customer->save();

            return $customer;
        }

        $customer = new Customer();

        $customer->fill([
            'name' => Arr::get($profile, 'name')
                ?? Arr::get($profile, 'given_name')
                ?? __('Google user'),
            'email' => Arr::get($profile, 'email') ?: sprintf('google_%s@rubyshop.local', $googleId),
            'password' => bcrypt(Str::random(40)),
            'status' => CustomerStatusEnum::ACTIVATED,
        ]);

        $customer->google_id = $googleId;
        $customer->google_avatar = Arr::get($profile, 'picture');
        $customer->confirmed_at = Carbon::now();

        $customer->save();

        return $customer;
    }

    protected function getRedirectUri(): string
    {
        return route('customer.google.callback');
    }

    protected function getClientId(): ?string
    {
        return config('services.google.client_id');
    }

    protected function getClientSecret(): ?string
    {
        return config('services.google.client_secret');
    }

    protected function redirectWithError(?string $message = null): RedirectResponse
    {
        return redirect()
            ->route('customer.login')
            ->with('error_msg', $message ?: __('Unable to login with Google. Please try again.'));
    }
}
