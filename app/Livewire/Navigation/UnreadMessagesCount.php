<?php

namespace App\Livewire\Navigation;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class UnreadMessagesCount extends Component
{
    public function render()
    {
        $unreadCount = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('livewire.navigation.unread-messages-count', [
            'unreadCount' => $unreadCount
        ]);
    }
}
