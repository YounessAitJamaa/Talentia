<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $users = User::with('profile')
            ->whereKeyNot(Auth::user()->id)
            ->when($q !== '', fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

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
