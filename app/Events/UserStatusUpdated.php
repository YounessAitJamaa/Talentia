<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class UserStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $status; 

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $status)
    {
        $this->userId = $userId;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [new Channel('user-status')];
    }

    public function broadcastAs(): string
    {
        return 'user.status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'userId' => $this->userId,
            'status' => $this->status,
        ];
    }

}









