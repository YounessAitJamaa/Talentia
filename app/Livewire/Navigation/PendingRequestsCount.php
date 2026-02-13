<?php

namespace App\Livewire\Navigation;

use Livewire\Component;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;

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
