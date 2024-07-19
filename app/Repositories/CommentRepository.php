<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * Create a new comment for a post.
     */
    public function create(Post $post, array $data): Comment
    {
        return $post->comments()->create($data);
    }

    /**
     * Delete a comment.
     */
    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
