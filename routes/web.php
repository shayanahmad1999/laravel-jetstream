<?php

use App\Livewire\Posts\CreatePost;
use App\Livewire\Posts\EditPost;
use App\Livewire\Posts\IndexPost;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['multiRole:Super Admin,Admin,Creator'])->group(function () {
        Route::get('/posts', IndexPost::class)->name('posts.index');
        Route::get('/posts/create', CreatePost::class)->name('posts.create');
        Route::get('/posts/{slug}/edit', EditPost::class)->name('posts.edit');
    });
});
