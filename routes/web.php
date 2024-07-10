<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/* Posts Routes */
Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

/* Comments Routes */
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('posts.comments.store');

Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('posts.comments.destroy');
