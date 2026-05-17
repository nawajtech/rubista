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
        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
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
}
