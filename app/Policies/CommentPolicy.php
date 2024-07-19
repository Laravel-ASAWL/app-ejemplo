<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use App\Repositories\PostRepository;

class CommentPolicy
{
    public function __construct(
        private PostRepository $postRepository
    ) {}

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
    public function verificateEmail(User $user): bool
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
        $post = $this->postRepository->post($comment);

        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        $post = $this->postRepository->post($comment);

        return $user->id === $post->user_id || $user->id === $comment->user_id;
    }
}
