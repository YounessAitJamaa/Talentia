<?php

use Livewire\Component;

class PendingRequestsCount extends Component
{
    public function render()
    {
        $pendingCount = Friendship::where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->count();
        return view('livewire.navigation.pending-requests-count', [
            'pendingCount' => $pendingCount
        ]);
    }
}
?>

<div wire:poll.5s>
    @if($pendingCount > 0)
        <!-- Badge HTML -->
        <span class="...">{{ $pendingCount }}</span>
    @endif
</div>