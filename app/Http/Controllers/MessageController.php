<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class MessageController extends Controller
{
    public function show($id = null)
    {
        $conversations = User::whereHas('sentMessages', function ($query) {
            $query->where('receiver_id', auth()->id());
        })->orWhereHas('receivedMessages', function ($query) {
            $query->where('sender_id', auth()->id());
        })->with('profile')->get();

        $receiver = null;
        $messages = collect();

        if ($id) {
            $receiver = User::findOrFail($id);
        } elseif ($conversations->isNotEmpty()) {
            // Find the last user we exchanged messages with
            $lastMessage = Message::where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id())
                ->latest()
                ->first();

            if ($lastMessage) {
                $partnerId = ($lastMessage->sender_id == auth()->id()) ? $lastMessage->receiver_id : $lastMessage->sender_id;
                $receiver = User::find($partnerId);
            }

            if (!$receiver && $conversations->isNotEmpty()) {
                $receiver = $conversations->first();
            }
        }

        if ($receiver) {
            $messages = Message::query()
                ->where(function ($query) use ($receiver) {
                    $query->where('sender_id', auth()->id())
                        ->where('receiver_id', $receiver->id);
                })
                ->orWhere(function ($query) use ($receiver) {
                    $query->where('sender_id', $receiver->id)
                        ->where('receiver_id', auth()->id());
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
