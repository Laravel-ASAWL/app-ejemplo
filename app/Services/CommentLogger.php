<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class CommentLogger
{
    /**
     * Log a comment creation event.
     *
     * @param  string  $commentBody
     */
    public function logCommentCreated(Post $post, Comment $comment): void
    {
        Log::info(__('Comment created successfully!'), [
            'ip_address' => Request::ip(),
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment_id' => $comment->id,
        ]);
    }

    /**
     * Log a comment deletion event.
     *
     * @param  int  $commentId
     */
    public function logCommentDeleted(Post $post, Comment $comment): void
    {
        Log::info(__('Comment deleted successfully!'), [
            'ip_address' => Request::ip(),
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment_id' => $comment->id,
        ]);
    }

    /**
     * Log a comment creation failed validation.
     *
     * @param  int  $commentId
     */
    public function logCommentFailedDValidation(Post $post, array $messages): void
    {
        Log::warning(__('Comment failed validation!'), array_merge([
            'ip_address' => Request::ip(),
            'user_id' => auth()->user()->id ?? 'Unknown',
            'post_id' => $post->id,
        ], $messages));
    }

    /**
     * Log an unauthorized comment creation attempt.
     */
    public function logUnauthorizedCreationAttempt(Post $post, string $commentBody): void
    {
        Log::warning(__('Unauthorized attempt to create a comment.'), [
            'ip_address' => Request::ip(),
            'user_id' => auth()->check() ? auth()->user()->id : 'Unknown',
            'post_id' => $post->id,
            'comment_body' => $commentBody,
        ]);
    }

    /**
     * Log an unauthorized comment deletion attempt.
     *
     * @param  int  $commentId
     */
    public function logUnauthorizedDeletionAttempt(Post $post, Comment $comment): void
    {
        Log::warning(__('Unauthorized attempt to delete a comment.'), [
            'ip_address' => Request::ip(),
            'user_id' => auth()->check() ? auth()->user()->id : 'Unknown',
            'post_id' => $post->id,
            'comment_id' => $comment->id,
        ]);
    }

    /**
     * Log an unverified email creation attempt.
     */
    public function logUnverifiedEmailCreationAttempt(Post $post, string $commentBody): void
    {
        Log::warning(__('Attempt to create a comment with unverified email.'), [
            'ip_address' => Request::ip(),
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment_body' => $commentBody,
        ]);
    }

    /**
     * Log an unverified email deletion attempt.
     */
    public function logUnverifiedEmailDeletionAttempt(Post $post, Comment $comment): void
    {
        Log::warning(__('Attempt to delete a comment with unverified email.'), [
            'ip_address' => Request::ip(),
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment_id' => $comment->id,
        ]);
    }
}
