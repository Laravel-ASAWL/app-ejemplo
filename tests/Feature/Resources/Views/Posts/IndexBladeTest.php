<?php

namespace Tests\Feature\Resources\Views\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexBladeTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Index blade renders with posts.
     */   
    public function test_index_blade_renders_with_posts()
    {
        Post::factory(50)->create();
        $posts = Post::latest()->with('user')->paginate(10);
        $posts = $posts->fragment('posts');
        View::share('posts', $posts);

        $renderedView = View::make('posts.index')->render();

        $this->assertStringContainsString(__('WASAL'), $renderedView);
        $this->assertStringContainsString(__('Web Application Security Analysis Laravel'), $renderedView);
        $this->assertStringContainsString(__('Latest Posts'), $renderedView);
        $this->assertStringContainsString(__('Date'), $renderedView);
        $this->assertStringContainsString(__('Read more'), $renderedView);
    }

    /**
     * Index blade renders without posts.
     */   
    public function test_index_blade_renders_without_posts()
    {
        View::share('posts', null);

        $renderedView = View::make('posts.index')->render();

        $this->assertStringContainsString(__('WASAL'), $renderedView);
        $this->assertStringContainsString(__('Web Application Security Analysis Laravel'), $renderedView);
        $this->assertStringContainsString(__('Be the first to share your thoughts and opinions!'), $renderedView);
        $this->assertStringContainsString(__('Log in'), $renderedView);
        $this->assertStringContainsString(__('Register'), $renderedView);
    }
}
