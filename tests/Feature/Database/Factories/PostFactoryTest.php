<?php

namespace Tests\Feature\Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostFactoryTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * test post factory creates valid post
     */
    public function test_post_factory_creates_valid_post()
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'title' => $post->title,
            'slug' => $post->slug,
            'description' => $post->description,
            'body' => $post->body,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ]);

        $this->assertNotNull($post->id);
        $this->assertNotNull($post->user_id);
        $this->assertNotEmpty($post->title);
        $this->assertNotEmpty($post->slug);
        $this->assertNotEmpty($post->description);
        $this->assertNotEmpty($post->body);
        $this->assertNotEmpty($post->created_at);
        $this->assertNotEmpty($post->updated_at);

        $this->assertIsInt($post->id);
        $this->assertInstanceOf(User::class, $post->user);
        $this->assertIsString($post->title);
        $this->assertIsString($post->slug);
        $this->assertIsString($post->description);
        $this->assertIsString($post->body);
        $this->assertInstanceOf(Carbon::class, $post->created_at);
        $this->assertInstanceOf(Carbon::class, $post->updated_at);
    }
}
