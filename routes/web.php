<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\FriendshipController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommunityController;
use Laravel\Socialite\Socialite;


Route::get('/', function () {
    return view('welcome');
});

//for socialite login

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/auth/callback', [GoogleController::class,'loginGoogle']);
//////////////////////////

Route::get('/dashboard', [ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->middleware(['auth'])->name('profile.show');

Route::middleware('auth')->group(function () {
    Route::post('/friendship/send/{id}', [FriendshipController::class, 'sendRequest'])->name('friendship.send');
    Route::post('/friendship/accept/{id}', [FriendshipController::class, 'acceptRequest'])->name('friendship.accept');
    Route::get('/invitations', [FriendshipController::class, 'index'])->name('friendships.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/community', [CommunityController::class, 'index'])
        ->name('community.index');

    Route::get('/community/{user}', [CommunityController::class, 'show'])
        ->name('community.show');
});
require __DIR__.'/auth.php';
