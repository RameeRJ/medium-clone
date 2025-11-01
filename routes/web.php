<?php

use App\Http\Controllers\ClapController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/create', [PostController::class, 'store'])->name('post.store');
    Route::post('/follow/{user:id}', [FollowController::class, 'followUnfollow'])->name('follow');
    Route::post('/clap/{post:id}', [ClapController::class, 'clap'])->name('clap');
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [PostController::class, 'index'])->name('dashboard');
Route::get('/@{user}/{post}', [PostController::class, 'show'])->name('post.show');
Route::get('/@{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/category/{category}', [PostController::class, 'category'])->name('post.category');

require __DIR__.'/auth.php';
