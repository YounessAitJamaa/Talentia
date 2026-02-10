<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

class OAuthController extends Controller
{
    public function loginGithub() {
     $githubUser = Socialite::driver('github')->user();

    $user = User::updateOrCreate([
        'email' => $githubUser->email,
    ], [
        'name' => $githubUser->name,
        'role' => 'chercheur',
        'email' => $githubUser->email,
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
    ]);

    Auth::login($user);
        $profile = Profile::updateOrCreate([
            'user_id' => $user->id,
            'photo'=> $githubUser->getAvatar()
        ]);

if ($user->wasRecentlyCreated) {
    return redirect('/choseRole');
}
    return redirect('/dashboard');
    }

    public function loginGoogle() {
    $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'email' => $googleUser->email,
    ], [
        'name' => $googleUser->name,
        'role' => 'chercheur',
        'email' => $googleUser->email,
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
    ]);

    Auth::login($user);
        $profile = Profile::updateOrCreate([
            'user_id' => $user->id,
            'photo'=> $googleUser->getAvatar()
        ]);
if ($user->wasRecentlyCreated) {
    return redirect('/choseRole');
}
    return redirect('/dashboard');
    }
}
