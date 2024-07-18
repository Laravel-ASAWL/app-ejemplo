<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can access models.
     */
    public function auth(User $user): bool
    {
        return auth()->check();
    }

    /**
     * Determine whether the user has verificated email.
     */
    public function verificatedEmail(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can delete the comment.
     */
    public function ownerComment(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user is owner of the post.
     */
    public function ownerPost(User $user, Comment $comment): bool
    {
        $post = Post::where('id', $comment->post_id)
            ->select('user_id')
            ->first();

        return $user->id === $post->user_id;
    }
}
