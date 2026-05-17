<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class FacebookLoginController extends Controller
{
    public function redirectToFacebook()
    {
        if (! $this->facebookCredentialsConfigured()) {
            return redirect()
                ->route('frontend.login')
                ->with('error', 'Facebook login is not configured. Add FACEBOOK_CLIENT_ID and FACEBOOK_CLIENT_SECRET to .env, then run: php artisan config:clear');
        }

        return $this->facebookDriver()
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        if (! $this->facebookCredentialsConfigured()) {
            return redirect()
                ->route('frontend.login')
                ->with('error', 'Facebook login is not configured on the server.');
        }

        try {
            $facebookUser = $this->facebookDriver()->user();
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('frontend.login')
                ->with('error', 'Facebook login failed. Please try again or use email login.');
        }

        $email = $facebookUser->getEmail();
        $facebookId = $facebookUser->getId();
        $name = $facebookUser->getName() ?? 'Facebook User';

        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    'name' => $user->name ?: $name,
                    'facebook_id' => $facebookId,
                ]);
            } else {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'facebook_id' => $facebookId,
                    'password' => bcrypt(Str::random(24)),
                ]);
            }
        } else {
            $user = User::updateOrCreate(
                ['facebook_id' => $facebookId],
                [
                    'name' => $name,
                    'email' => 'facebook_' . $facebookId . '@rubista.local',
                    'password' => bcrypt(Str::random(24)),
                ]
            );
        }

        Auth::login($user, true);

        return redirect()->intended('/');
    }

    private function facebookDriver()
    {
        return Socialite::driver('facebook')
            ->redirectUrl($this->facebookRedirectUrl());
    }

    private function facebookRedirectUrl(): string
    {
        return route('auth.facebook.callback', [], true);
    }

    private function facebookCredentialsConfigured(): bool
    {
        return config('services.facebook.client_id') !== ''
            && config('services.facebook.client_secret') !== '';
    }
}
