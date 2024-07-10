<?php

namespace Tests\Feature\App\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It has the correct fillable attributes.
     */
    public function test_it_has_the_correct_fillable_attributes()
    {
        $user = new User;
        $fillable = ['name', 'email', 'password'];

        $this->assertEquals($fillable, $user->getFillable());
    }

    /**
     * An user has many comments.
     * */
    public function test_an_user_has_many_comments()
    {
        $user = User::factory()->create();
        Comment::factory(10)->for($user)->create();

        $this->assertCount(10, $user->comments);
        $this->assertInstanceOf(Comment::class, $user->comments->first());
    }

    /**
     * An user has many posts.
     * */
    public function test_an_user_has_many_posts()
    {
        $user = User::factory()->create();
        Post::factory(10)->for($user)->create();

        $this->assertCount(10, $user->posts);
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }

    /**
     * An user can be created.
     */
    public function test_an_user_can_be_created()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ];
        $user = User::factory()->create($data);
        $post = Post::factory()->for($user)->create();
        $comment = Comment::factory()->for($user)->create();

        $this->assertDatabaseHas('users', $data);
        $this->assertTrue($post->user->is($user));
        $this->assertTrue($comment->user->is($user));
    }
}
