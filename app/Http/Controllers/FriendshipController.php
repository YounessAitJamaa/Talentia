<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{

    public function index()
    {
        $invitations = Friendship::where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->with('sender.profile')
            ->get();

        return view('friendships.index', compact('invitations'));
    }


    public function sendRequest($friendId) 
    {
        $userId = Auth::id();

        if($userId == $friendId) {
            return back()->with('error', 'Vous ne pouvez pas vous ajouter vous-même.');
        }

         $existingFriendship = Friendship::where(function($query) use ($userId, $friendId) {
                $query->where('user_id', $userId)->where('friend_id', $friendId);
            })->orWhere(function($query) use ($userId, $friendId) {
                $query->where('user_id', $friendId)->where('friend_id', $userId);
            })->first();


        if($existingFriendship && $existingFriendship->status == 'rejected') {

            $existingFriendship->update([
                'status' => 'pending',
            ]);

            return back()->with('status', 'Nouvelle demande de connexion envoyée !');
        }

        Friendship::create([
            'user_id' => $userId,   
            'friend_id' => $friendId,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Demande de connexion envoyée !');
    }

    
    public function acceptRequest($id) {

        $friendship = Friendship::where('id', $id)
                ->where('friend_id', Auth::id())
                ->where('status', 'pending')
                ->firstOrFail();

        $friendship->update([
            'status' => 'accepted'
        ]);

        return back()->with('status', 'Connexion acceptée ! Vous faites maintenant partie du même réseau.');
    }

    public function rejectRequest($id)
    {
        $friendship = Friendship::where('id', $id)
                        ->where('friend_id', Auth::id())
                        ->where('status', 'pending')
                        ->firstOrFail();
        
        $friendship->update([
            'status' => 'rejected'
        ]);

        return back()->with('status', 'Connexion Rejectee ! You rejected the friend request');
    }
}
