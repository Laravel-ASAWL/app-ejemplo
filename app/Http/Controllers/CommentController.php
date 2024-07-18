<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestComment;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Comment model.
     */
    protected Comment $comment;

    /**
     * Post model.
     */
    protected Post $post;

    /**
     * Comment body.
     */
    protected string $comment_body;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestComment $request, Post $post): RedirectResponse
    {
        $this->post = $post;
        $this->comment_body = $request->validated('body');

        if (! Gate::allows('auth', Comment::class))
            return $this->storeAuthLog();

        if (! Gate::allows('verificatedEmail', Comment::class))
            return $this->storeVerificatedEmailLog();

        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
            'body' => $this->comment_body,
        ]);

        return $this->storeCommentLog();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment): RedirectResponse
    {
        $this->post = $post;
        $this->comment = $comment;

        if (! Gate::allows('authCheck', $comment))
            return $this->destroyAuthLog();

        if (! Gate::allows('hasVerificatedEmail', Comment::class))
            return $this->destroyVerificatedEmailLog();

        if ((! Gate::allows('ownerComment', $comment)) and (! Gate::allows('ownerPost', $comment)))
            return $this->destroyOwwerLog();

        $comment->delete();

        return $this->destroyCommentLog();
    }

    /**
     * Save log if user cannot create comment because is not authorized.
     */
    private function storeAuthLog(): RedirectResponse
    {
        Log::warning(__('You are not authorized to create comments.'), [
            'user_id' => 'Unknown',
            'post_id' => $this->post->id,
            'comment_body' => $this->comment_body,
        ]);

        return redirect()->route('posts.show', $this->post->slug)
            ->withErrors(['error' => __('You are not authorized to create comments.')])
            ->withFragment('comments')
            ->withInput();
    }

    /**
     * Save log if user cannot create comment because has verificated email.
     */
    private function storeVerificatedEmailLog(): RedirectResponse
    {
        Log::warning(__('You has not verified email address.'), [
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
            'comment_body' => $this->comment_body,
        ]);

        return redirect()->route('posts.show', $this->post->slug)
            ->withErrors(['error' => __('You has not verified email address.').' <a href="'.route('verification.notice').'" class="underline">'.__('Click here to verify your email address').'</a>.'])
            ->withFragment('comments')
            ->withInput();
    }

    /**
     * Save log if comment was created successfully.
     */
    private function storeCommentLog(): RedirectResponse
    {
        Log::info(__('Comment created successfully!'), [
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
            'comment_body' => $this->comment_body,
        ]);

        return redirect()->route('posts.show', $this->post->slug)
            ->with('success', __('Comment created successfully!'))
            ->withFragment('comments');
    }

    /**
     * Save log if user cannot delete comment because is not authorized.
     */
    private function destroyAuthLog(): RedirectResponse
    {
        Log::warning(__('You are not authorized to delete comments.'), [
            'user_id' => 'Unknown',
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
        ]);

        return redirect()->route('posts.show', $this->post->slug)
            ->withErrors(['error' => __('You are not authorized to delete comments.')])
            ->withFragment('comments')
            ->withInput();
    }

    /**
     * Save log if user cannot delete comment because has verificated email.
     */
    private function destroyVerificatedEmailLog(): RedirectResponse
    {
        Log::warning(__('You has not verified email address.'), [
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
            'comment_if' => $this->comment->id,
        ]);

        return redirect()->route('posts.show', $this->post->slug)
            ->withErrors(['error' => __('You has not verified email address.').' <a href="'.route('verification.notice').'" class="underline">'.__('Click here to verify your email address').'</a>.'])
            ->withFragment('comments')
            ->withInput();
    }

    /**
     * Save log if user cannot delete comment because user is not owner.
     */
    private function destroyOwwerLog(): RedirectResponse
    {
        Log::error(__('You are not authorized to delete comments.'), [
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
        ]);

        return redirect()->route('posts.show', $this->post->slug)
            ->withInput()
            ->withErrors(['error' => __('You are not authorized to delete comments.')])
            ->withFragment('comments');
    }

    /**
     * Save log if comment was deleted successfully.
     */
    private function destroyCommentLog(): RedirectResponse
    {
        Log::info(__('Comment deleted successfully!'), [
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
        ]);

        return redirect()->route('posts.show', $this->post->slug)
            ->with('success', __('Comment deleted successfully!'))
            ->withFragment('comments');
    }
}
