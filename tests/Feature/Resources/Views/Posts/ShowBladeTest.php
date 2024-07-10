<?php

namespace Tests\Feature\Resources\Views\Posts;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class ShowBladeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Show blade renders post with comments.
     */
    public function test_show_blade_renders_post_with_comments()
    {
        $post = Post::factory()->create();
        Comment::factory(10)->create(['post_id' => $post->id]);
        $comments = Comment::latest()->with('user')->paginate(10);
        $comments = $comments->fragment('comments');
        View::share('post', $post);
        View::share('comments', $comments);

        $renderedView = View::make('posts.show')->render();

        $this->assertStringContainsString($post->title, $renderedView);
        $this->assertStringContainsString($post->description, $renderedView);
    }

    /**
     * Show blade renders post without comments.
     */
    public function test_show_blade_renders_post_without_comments()
    {
        $post = Post::factory()->create();
        View::share('post', $post);
        View::share('comments', null);

        $renderedView = View::make('posts.show')->render();

        $this->assertStringContainsString($post->title, $renderedView);
        $this->assertStringContainsString($post->description, $renderedView);
        $this->assertStringContainsString(__('There are no comments on this post.'), $renderedView);
    }
}
