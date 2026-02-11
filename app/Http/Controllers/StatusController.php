<?php



namespace App\Http\Controllers;

use App\Events\UserStatusUpdated;
use App\Models\User;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function updateStatus($status)
    {
        $user = auth()->user();
        
        // Mettre à jour le statut de l'utilisateur
        $user->status = $status;
        $user->save();

        // Diffuser l'événement
        broadcast(new UserStatusUpdated($user->id, $status));
        
        return response()->json(['status' => $status]);
    }
}

