<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\FriendshipController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->middleware(['auth'])->name('profile.show');

Route::middleware('auth')->group(function () {

    Route::post('/friendship/send/{id}', [FriendshipController::class, 'sendRequest'])->name('friendship.send');
    Route::post('/friendship/accept/{id}', [FriendshipController::class, 'acceptRequest'])->name('friendship.accept');
    Route::post('/friendship/reject/{id}', [FriendshipController::class, 'rejectRequest'])->name('friendship.reject');

    Route::get('/invitations', [FriendshipController::class, 'index'])->name('friendships.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/friends', [FriendshipController::class, 'showFriendsList'])->name('friends');

    Route::get('/messages', [MessageController::class, 'show'])->name('messages.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/community', [CommunityController::class, 'index'])
        ->name('community.index');

    Route::get('/community/{user}', [CommunityController::class, 'show'])
        ->name('community.show');

    Route::get('/my-jobs', App\Livewire\RecruiterDashboard::class)->name('recruiter.dashboard');
    Route::get('/jobs/{jobId}/applications', App\Livewire\JobApplications::class)->name('job.applications');
});
require __DIR__ . '/auth.php';
