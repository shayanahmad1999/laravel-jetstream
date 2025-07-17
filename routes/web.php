<?php

use App\Livewire\Home\Home;
use App\Livewire\Posts\CreatePost;
use App\Livewire\Posts\EditPost;
use App\Livewire\Posts\IndexPost;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\EditUser;
use App\Livewire\Users\IndexUser;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', Home::class)->name('dashboard');
    Route::get('/liked-post', [Home::class, 'likedPost'])->name('likedPost');

    Route::middleware(['multiRole:Super Admin,Admin,Creator'])->group(function () {
        Route::get('/posts', IndexPost::class)->name('posts.index');
        Route::get('/posts/create', CreatePost::class)->name('posts.create');
        Route::get('/posts/{slug}/edit', EditPost::class)->name('posts.edit');
    });

    Route::middleware(['multiRole:Super Admin,Admin'])->group(function () {
        Route::get('/users', IndexUser::class)->name('users.index');
        Route::get('/users/create', CreateUser::class)->name('users.create')->middleware('can:create,' . User::class);
        Route::get('/users/{user}/edit', EditUser::class)->name('users.edit')->middleware('can:update,user');
    });
});
