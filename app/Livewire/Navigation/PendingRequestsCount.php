<?php

namespace App\Livewire\Navigation;

use App\Models\Application;
use Livewire\Component;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;

class PendingRequestsCount extends Component
{
    public function render()
    {
        $pendingRequests = Friendship::where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        $unreadApplications = Application::where('user_id', Auth::id())
            ->whereIn('status', ['accepted', 'refused'])
            ->where('is_seen', false)
            ->count();

        return view('livewire.navigation.pending-requests-count', [
            'pendingCount' => $pendingRequests + $unreadApplications
        ]);
    }
}
