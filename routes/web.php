<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\FriendshipController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

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

require __DIR__.'/auth.php';
