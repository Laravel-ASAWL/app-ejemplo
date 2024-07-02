<?php

namespace Tests\Feature\Blog;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 
     */
    public function test_database_seeder()
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'name' => 'asawl',
            'email' => 'asawl@ejemplo.com',
        ]);
    }

    /**
     * A post can be created.
     */
    public function test_creates_post_with_user_relationship()
    {
        $user = User::factory()->create([
            'name' => 'asawl',
            'email' => 'asawl@ejemplo.com',
        ]);

        $post = Post::factory()->has(Comment::factory(50))->for($user)->create();

        $this->assertDatabaseHas('posts', [
            'user_id' => $post->user_id,
            'title' => $post->title,
            'slug' => $post->slug,
            'description' => $post->description,
            'body' => $post->body,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ]);
    }

    /**
     * Posts page can be loaded.
     */
    public function test_posts_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
