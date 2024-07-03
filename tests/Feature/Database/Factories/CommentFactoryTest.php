<?php

namespace Tests\Feature\Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentFactoryTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * test comment factory creates valid comment
     */
    public function test_comment_factory_creates_valid_comment()
    {
        $comment = Comment::factory()->create();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'post_id' => $comment->post_id,
            'body' => $comment->body,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
        ]);

        $this->assertNotNull($comment->id);
        $this->assertNotNull($comment->user_id);
        $this->assertNotNull($comment->post_id);
        $this->assertNotEmpty($comment->body);
        $this->assertNotEmpty($comment->created_at);
        $this->assertNotEmpty($comment->updated_at);

        $this->assertIsInt($comment->id);
        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertInstanceOf(Post::class, $comment->post);
        $this->assertIsString($comment->body);
        $this->assertInstanceOf(Carbon::class, $comment->created_at);
        $this->assertInstanceOf(Carbon::class, $comment->updated_at);
    }
}
