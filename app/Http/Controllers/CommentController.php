<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestComment;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestComment $request, Post $post): RedirectResponse
    {
        if ((! auth()->user() instanceof Authenticatable) or (! Gate::allows('create', Comment::class))) {
            Log::error(__('You are not authorized to create comments.'), ['auth_user' => auth()->user() ?? 'Unknown']);

            return redirect()->route('posts.show', $post->slug)
                ->withInput()
                ->withErrors(['error' => __('You are not authorized to create comments.')])
                ->withFragment('comments');
        }

        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'body' => $request->validated('body'),
        ]);

        return redirect()->route('posts.show', $post->slug)
            ->with('success', __('Comment created successfully!'))
            ->withFragment('comments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment): RedirectResponse
    {
        if ((! auth()->user() instanceof Authenticatable) or (! Gate::allows('delete', $comment))) {
            Log::error(__('You are not authorized to delete comments.'), ['auth_user' => auth()->user() ?? 'Unknown']);

            return redirect()->route('posts.show', $post->slug)
                ->withInput()
                ->withErrors(['error' => __('You are not authorized to delete comments.')])
                ->withFragment('comments');
        }

        $comment->delete();

        return redirect()->route('posts.show', $post->slug)
            ->with('success', __('Comment deleted successfully!'))
            ->withFragment('comments');
    }
}
