<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function sendRequest($friendId) 
    {
        $userId = Auth::id();

        if($userId == $friendId) {
            return back()->with('error', 'Vous ne pouvez pas vous ajouter vous-même.');
        }

        $exists = Friendship::where(function($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $userId);
        })->first();

        if(!$exists) {
            Friendship::create([
                'user_id' => $userId,
                'friend_id' => $friendId,
                'status' => 'pending',
            ]);
            return back()->with('status', 'Demande de connexion envoyée !');
        }

        return back()->with('status', 'Une demande est déjà en cours.');
    }
}
