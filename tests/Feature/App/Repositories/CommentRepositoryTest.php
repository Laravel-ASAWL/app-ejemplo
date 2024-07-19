<?php

namespace Tests\Feature\App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\CommentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It creates a comment.
     */
    public function test_it_creates_a_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $data = ['user_id' => $user->id, 'body' => 'Test comment'];

        $repository = new CommentRepository;
        $comment = $repository->create($post, $data);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($data['body'], $comment->body);
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);
    }

    /**
     * It deletes a comment.
     */
    public function test_it_deletes_a_comment()
    {
        $comment = Comment::factory()->create();
        $repository = new CommentRepository;

        $result = $repository->delete($comment);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
