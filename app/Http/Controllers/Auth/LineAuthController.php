<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Botble\Ecommerce\Models\Customer;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LineAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('line')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $lineUser = Socialite::driver('line')->user();
        } catch (Exception $exception) {
            report($exception);

            return $this->redirectWithError();
        }

        if (! $lineUser || ! $lineUser->getId()) {
            return $this->redirectWithError();
        }

        $customer = Customer::query()
            ->where('line_id', $lineUser->getId())
            ->orWhere(function ($query) use ($lineUser) {
                if ($lineUser->getEmail()) {
                    $query->where('email', $lineUser->getEmail());
                }
            })
            ->first();

        if (! $customer) {
            $customer = Customer::create([
                'name' => $lineUser->getName() ?: $lineUser->getNickname() ?: __('LINE user'),
                'email' => $lineUser->getEmail() ?: sprintf('line_%s@rubyshop.local', $lineUser->getId()),
                'password' => bcrypt(Str::random(32)),
                'line_id' => $lineUser->getId(),
                'line_avatar' => $lineUser->getAvatar(),
                'status' => 'activated',
            ]);
        } else {
            $customer->forceFill([
                'line_id' => $customer->line_id ?: $lineUser->getId(),
                'line_avatar' => $lineUser->getAvatar() ?: $customer->line_avatar,
            ])->save();
        }

        Auth::guard('customer')->login($customer, true);

        return redirect()->intended(route('customer.overview'));
    }

    protected function redirectWithError(): RedirectResponse
    {
        return redirect()
            ->route('customer.login')
            ->with('error_msg', __('Unable to login with LINE. Please try again.'));
    }
}
