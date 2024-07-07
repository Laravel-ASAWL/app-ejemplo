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
        $posts = Post::latest()->with('user')->paginate(10);
        $posts = $posts->fragment('posts');
        
        $response = $this->get(route('posts.index'));

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

        $response->assertNotFound();
    }

    /**
     * Show page displays post.
     */
    public function test_show_displays_post()
    {
        $post = Post::factory()->create();
        
        $response = $this->get(route('posts.show', $post->slug));
        
        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
    }

    /**
     * Show page displays message when post has no comments.
     */
    public function test_show_displays_message_when_post_has_no_comments()
    {
        $post = Post::factory()->create();
        
        $response = $this->get(route('posts.show', $post->slug));
        
        $this->assertDatabaseCount('comments', 0);
        $response->assertSee(__('Join the conversation!'));
    }

    /**
     * Show page displays post with paginated comments.
     */
    public function test_show_displays_post_with_paginated_comments()
    {
        $post = Post::factory()->create();
        Comment::factory()->create(['post_id' => $post->id]);
        $comments = Comment::latest()->with('user')->paginate(10);
        $comments = $comments->fragment('comments');

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
        $this->assertInstanceOf(LengthAwarePaginator::class, $comments);
    }
}
