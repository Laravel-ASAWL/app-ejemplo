<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Show all posts.
     */
    public function posts(): array
    {
        return [
            'posts' => Post::count() > 0 ? Post::latest()
                ->select('title', 'slug', 'description', 'created_at')
                ->paginate(10) : null,
        ];
    }

    /**
     * Show the post of comment.
     */
    public function post(Comment $comment): Post
    {
        return Post::where('id', $comment->post_id)
            ->select('user_id')
            ->first();
    }

    /**
     * Show all comments of a post.
     */
    public function postComments(Post $post): ?LengthAwarePaginator
    {
        return $post->comments()->count() > 0 ? $post->comments()->latest()
            ->select('id', 'user_id', 'post_id', 'body', 'created_at')
            ->with('user:id,name,email')
            ->paginate(10) : null;
    }
}
