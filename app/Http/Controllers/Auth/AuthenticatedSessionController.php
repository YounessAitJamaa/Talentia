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
        // Validation avec $request->validate()
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Authentifier l'utilisateur
        if (Auth::attempt($validated)) {
            $user = Auth::user();

            // Diffuser l'événement de statut en ligne
            event(new UserStatusUpdated($user->id, 'online'));

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Les informations d\'identification sont incorrectes.']);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $user = auth()->user();
        if ($user) {
            $user->status = 'offline';
            $user->save();

            // Diffuser l'événement de mise à jour du statut
            broadcast(new UserStatusUpdated($user->id, 'offline'));
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


}
