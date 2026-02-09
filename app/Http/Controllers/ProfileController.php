<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function index(Request $request) {

            $role = $request->role;
            $search = $request->search;

            if($role === 'chercheur') {
                $users = User::where('role', 'chercheur')
                            ->where('id', '!=', Auth::id())->get();
            }
            elseif ($role === 'recruteur') {
                $users = User::where('role', 'recruteur')
                            ->where('id', '!=', Auth::id())->get();
            }
            elseif($search){
                $users = User::where('name', 'LIKE', "%$search%")
                            ->where('id', '!=', Auth::id())->get();
            }else {
                $users = User::where('id', '!=', Auth::id())->get();
            }

            return view('dashboard', compact('users'));
    }

    public function show($id) {
        $user = User::with('profile')->findOrFail($id);

        $status = $this->friendshipStatus($user->id);

        return view('profile.show', compact('user', 'status'));
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $profileData = [
            'specialty' => $request->validated('specialty'),
            'bio' => $request->validated('bio'),
        ];

        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profiles', 'public');
            $profileData['photo'] = $path;
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function friendshipStatus(int $otherUserId): ?string
    {
        $me = Auth::id();

        if (!$me || $me === $otherUserId) {
            return null;
        }

        return \App\Models\Friendship::query()
            ->where(function ($q) use ($me, $otherUserId) {
                $q->where('user_id', $me)->where('friend_id', $otherUserId);
            })
            ->orWhere(function ($q) use ($me, $otherUserId) {
                $q->where('user_id', $otherUserId)->where('friend_id', $me);
            })
            ->value('status');
    }
}
