<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;

class CommunitySearch extends Component
{
    use WithPagination;

    public $q = '';

    public function updatedQ()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('profile')
            ->whereKeyNot(Auth::id())
            ->when($this->q !== '', fn($query) => $query->where('name', 'like', "%{$this->q}%"))
            ->latest()
            ->paginate(12);

        $authId = Auth::id();
        $friendships = Friendship::query()
            ->where(function ($q) use ($authId) {
                $q->where('user_id', $authId)->orWhere('friend_id', $authId);
            })
            ->get();

        $friendshipMap = [];
        foreach ($friendships as $f) {
            $otherId = ($f->user_id === $authId) ? $f->friend_id : $f->user_id;
            $friendshipMap[$otherId] = $f->status;
        }

        return view('livewire.community-search', compact('users', 'friendshipMap'));
    }
}
