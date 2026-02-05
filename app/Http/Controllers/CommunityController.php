<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $users = User::with('profile')
            ->whereKeyNot(Auth::user()->id)
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('community.index', compact('users', 'q'));
    }
    
}
