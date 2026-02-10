<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function show($id)
    {
        $receiver = User::findOrFail($id);

        $messages = Message::where(function ($query) use ($receiver) {
            $query->where('sender_id', auth()->id())->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($receiver) {
            $query->where('sender_id', $receiver->id)->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        return view('messages.index', compact('receiver' ,'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message =  Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        event(new MessageSent($message));

        return back();
    }
}
