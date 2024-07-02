<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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
Route::post('/comments/{post}', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');
