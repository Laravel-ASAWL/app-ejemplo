<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        $post = Post::where('id', $comment->post_id)->first();

        return $user->id === $comment->user_id || $user->id === $post->user_id;
    }
}
