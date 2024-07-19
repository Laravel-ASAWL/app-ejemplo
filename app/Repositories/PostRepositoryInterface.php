<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    /**
     * Show all posts.
     */
    public function posts(): array;

    /**
     * Show the post of comment.
     */
    public function post(Comment $comment): Post;

    /**
     * Show all comments of a post.
     */
    public function postComments(Post $post): ?LengthAwarePaginator;
}
