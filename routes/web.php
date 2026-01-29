<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    $users = User::all();
    return view('dashboard', compact('users'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile/{id}', function ($id) {
    $user = User::with('profile')->findOrFail($id);
    return view('profile.show', compact('user'));
})->middleware(['auth'])->name('profile.show');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
