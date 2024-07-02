<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     * 
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     * 
     * @return bool
     */
    public function view(User $user, Comment $comment): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     * 
     * @return bool
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     * 
     * @return bool
     */
    public function update(User $user, Comment $comment): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     * 
     * @return bool
     */
    public function delete(User $user, Comment $comment): bool
    {
        $post = Post::where('id', $comment->post_id)->first();

        return $user->id === $comment->user_id || $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     * 
     * @return bool
     */
    public function restore(User $user, Comment $comment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 
     * @return bool
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        //
    }}
