<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;

interface CommentRepositoryInterface
{
    /**
     * Create a new comment for a post.
     */
    public function create(Post $post, array $data): Comment;

    /**
     * Delete a comment.
     */
    public function delete(Comment $comment): bool;
}
