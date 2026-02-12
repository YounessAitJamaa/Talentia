<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class MessageController extends Controller
{
    public function show($id = null)
    {
        $user = auth()->user();
        $conversations = $user->friends()->with('profile')->get();

        $receiver = null;
        $messages = collect();

        if ($id) {
            $receiver = User::with('profile')->findOrFail($id);
        } else {
            // Find the last user we exchanged messages with
            $lastMessage = Message::where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id)
                ->latest()
                ->first();

            if ($lastMessage) {
                $partnerId = ($lastMessage->sender_id == $user->id) ? $lastMessage->receiver_id : $lastMessage->sender_id;
                $receiver = User::with('profile')->find($partnerId);
            }

            // If no messages yet, default to the first friend in the list
            if (!$receiver && $conversations->isNotEmpty()) {
                $receiver = $conversations->first();
            }
        }

        if ($receiver) {
            $messages = Message::query()
                ->where(function ($query) use ($receiver, $user) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $receiver->id);
                })
                ->orWhere(function ($query) use ($receiver, $user) {
                    $query->where('sender_id', $receiver->id)
                        ->where('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('messages.index', compact('receiver', 'messages', 'conversations'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->input('receiver_id'),
            'content' => $request->input('content'),
        ]);

        $message->load('sender');

        MessageSent::dispatch($message);

        return back();
    }
}
