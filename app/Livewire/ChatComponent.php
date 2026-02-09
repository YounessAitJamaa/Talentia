<?php 

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Message;
use Livewire\Component;


class ChatComponent extends Component 
{
    public $receiver;
    public $content;

    public function getListeners()
    {
        return [
            "echo-private:chat.{auth()->id()},MessageSent" => 'render',
        ];
    }

    public function sendMessage()
    {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiver->id,
            'content' => $this->content,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        $this->reset('content');
    }
}