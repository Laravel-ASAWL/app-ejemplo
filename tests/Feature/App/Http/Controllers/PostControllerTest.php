<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index page displays message when no posts exist.
     */
    public function test_index_displays_message_when_no_posts()
    {
        $response = $this->get(route('posts.index'));

        $this->assertDatabaseCount('posts', 0);
        $response->assertSee(__('Be the first to share your thoughts and opinions!'));
    }

    /**
     * Index page displays paginated posts.
     */
    public function test_index_displays_paginated_posts()
    {
        Post::factory(50)->create();
        $posts = Post::latest()
            ->select('title', 'slug', 'description', 'created_at')
            ->paginate(10);
        $posts = $posts->fragment('posts');

        $response = $this->get(route('posts.index'));

        $this->assertDatabaseCount('posts', 50);
        $response->assertOk();
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts', $posts);
        $this->assertInstanceOf(LengthAwarePaginator::class, $posts);
    }

    /**
     * Show page returns 404 for invalid slug.
     */
    public function test_show_returns_404_for_invalid_slug()
    {
        $response = $this->get(route('posts.show', 'post-invalid-slug'));

        $this->assertDatabaseCount('posts', 0);
        $response->assertNotFound();
    }

    /**
     * Show page displays post.
     */
    public function test_show_displays_post()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.show', $post->slug));

        $this->assertDatabaseCount('posts', 1);
        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
    }

    /**
     * Show page displays message to guest user.
     */
    public function test_show_displays_message_to_guest_user()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.show', $post->slug));

        $this->assertDatabaseCount('posts', 1);
        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
        $response->assertSee(__('We invite you to write a comment on this post and join the conversation. It doesn\'t matter if you are a beginner or an expert in Laravel security, we all have something valuable to contribute!'));
    }

    /**
     * Show page displays post with paginated comments.
     */
    public function test_show_displays_post_with_paginated_comments()
    {
        $post = Post::factory()->create();
        Comment::factory(50)->create(['post_id' => $post->id]);
        $comments = Comment::latest()->with('user:id,name,email')->paginate(10);
        $comments = $comments->fragment('comments');

        $response = $this->get(route('posts.show', $post->slug));

        $this->assertDatabaseCount('posts', 1);
        $this->assertDatabaseCount('comments', 50);
        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
        $this->assertInstanceOf(LengthAwarePaginator::class, $comments);
    }
}
