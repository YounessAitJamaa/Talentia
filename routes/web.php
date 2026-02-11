<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\FriendshipController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommunityController;
use Laravel\Socialite\Socialite;
use App\Http\Controllers\MessageController;
use App\Livewire\JobApplications;
use App\Livewire\RecruiterDashboard;

Route::get('/', function () {
    return view('welcome');
});

//////////////////////////
//for socialite login
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});
Route::get('/auth/callback', [OAuthController::class,'loginGoogle']);
Route::get('/auth/github/callback', [OAuthController::class,'loginGithub']);
Route::view('choseRole','choseRole');
Route::post('choseRole/setRole', [RegisteredUserController::class,'setRole'])->name('setRole');
//////////////////////////
//////////////////////////

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

    // Route::get('/friends', [FriendshipController::class, 'showFriendsList'])->name('friends');

    Route::get('/messages/{id?}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
});

Route::middleware('auth')->group(function () {
    Route::get('/community', [CommunityController::class, 'index'])
        ->name('community.index');

    Route::get('/community/{user}', [CommunityController::class, 'show'])
        ->name('community.show');

    Route::get('/my-jobs', RecruiterDashboard::class)->name('recruiter.dashboard');
    Route::get('/jobs/{jobId}/applications', JobApplications::class)->name('job.applications');
});
/////////////////////////
//stripe

require __DIR__ . '/auth.php';
