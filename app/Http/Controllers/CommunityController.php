<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $page = $request->get('page', 1);
        $cacheKey = "community_users_q_{$q}_page_{$page}";

        $users = Cache::remember($cacheKey, 3600, function () use ($q) {
            return User::with('profile')
                ->whereKeyNot(Auth::user()->id)
                ->when($q !== '', fn($query) => $query->where('name', 'like', "%{$q}%"))
                ->latest()
                ->paginate(12);
        });

        $users->withQueryString();

        $authId = Auth::id();

        $friendships = Friendship::query()
            ->where(function ($q) use ($authId) {
                $q->where('user_id', $authId)->orWhere('friend_id', $authId);
            })
            ->get();

        $friendshipMap = [];
        foreach ($friendships as $f) {
            $otherId = ($f->user_id === $authId) ? $f->friend_id : $f->user_id;
            $friendshipMap[$otherId] = $f->status;
        }

        return view('community.index', compact('users', 'q', 'friendshipMap'));
    }



}
