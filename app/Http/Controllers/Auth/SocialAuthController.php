<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Provider;
use App\Models\User;
use App\Models\SocialAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(Provider $provider)
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function callback(Provider $provider)
    {
        $socialUser = Socialite::driver($provider->value)->stateless()->user();
        $account = SocialAuth::where('provider_name', $provider->value)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if($account) {
            Auth::login($account->user);
            return redirect()->intended('/');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if(!$user) {
            $user = User::create([
                'first_name' => $socialUser->user['name'] ?? null,
                'last_name'  => $socialUser->user['name'] ?? null,
                'email'      => $socialUser->getEmail(),
                'avatar'     => $socialUser->getAvatar(),
                'password'   => 'password',
            ]);
        }

        $user->socialAuths()->create([
            'provider_name' => $provider->value,
            'provider_id' => $socialUser->getId(),
            'name' => $socialUser->getName(),
            'avatar' => $socialUser->getAvatar(),
        ]);

        Auth::login($user);
        return redirect()->intended('/');
    }
}
