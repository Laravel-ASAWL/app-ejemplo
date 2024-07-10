<?php

namespace Tests\Feature\App\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It has the correct fillable attributes.
     */
    public function test_it_has_the_correct_fillable_attributes()
    {
        $comment = new Comment();
        $fillable = ['id', 'user_id', 'post_id', 'body'];

        $this->assertEquals($fillable, $comment->getFillable());
    }

    /**
     * A comment belongs to a user.
     * */
    public function test_a_comment_belongs_to_a_user()
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }

    /**
     * A comment belongs to a post.
     * */
    public function test_a_comment_belongs_to_a_post()
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(Post::class, $comment->post);
    }
    
    /**
     * A comment can be created.
     */
    public function test_a_comment_can_be_created()
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $data = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => 'This is a test comment.',
        ];
        $comment = Comment::create($data);

        $this->assertDatabaseHas('comments', $data);
        $this->assertTrue($comment->user->is($user));
        $this->assertTrue($comment->post->is($post));
    }
}
