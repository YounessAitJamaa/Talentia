<?php

namespace App\Http\Middleware;

use App\Events\UserStatusUpdated;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if ($user) {
            $user->status = 'online'; 
            $user->save();
            // Diffuser l'événement
            broadcast(new UserStatusUpdated($user->id, 'online')); 
        }

        return $next($request);
    }



}
