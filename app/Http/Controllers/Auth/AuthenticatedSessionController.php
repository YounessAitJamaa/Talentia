<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Events\UserStatusUpdated;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Identifiants incorrects.']);
        }

        $request->session()->regenerate();

        $user = $request->user();

        // Force la mise à jour même si status n'est pas fillable
        $user->update(['status' => 'online']);
        $user->forceFill(['status' => 'online'])->save();

        broadcast(new \App\Events\UserStatusUpdated($user->id, 'online'));
        return redirect()->intended('/dashboard');
    }


    /**
     * Destroy an authenticated session.
     */
    

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user) {
            $user->forceFill(['status' => 'offline'])->save();
            broadcast(new \App\Events\UserStatusUpdated($user->id, 'offline'));
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    

}
