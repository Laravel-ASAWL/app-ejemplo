<?php

namespace Tests\Feature\App\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It has the correct fillable attributes.
    */
    public function test_it_has_the_correct_fillable_attributes()
    {
        $post = new Post();
        $fillable = ['id', 'user_id', 'title', 'slug', 'description', 'body'];

        $this->assertEquals($fillable, $post->getFillable());
    }    

    /**
     * A post belongs to a user.
    */
    public function test_a_post_belongs_to_a_user()
    {
        $post = Post::factory()->for(User::factory())->create();

        $this->assertInstanceOf(User::class, $post->user);
    }

    /**
     * A post has many comments.
    */
    public function test_a_post_has_many_comments()
    {
        $post = Post::factory()->create();
        Comment::factory(10)->for($post)->create();

        $this->assertCount(10, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments->first());
    }

    /**
     * A post can be created.
    */
    public function test_a_post_can_be_created()
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'title' => 'Test Post',
            'slug' => 'test-post',
            'description' => 'A short description',
            'body' => '✓ This is the body of the test post.'
        ];
        $post = Post::create($data);

        $this->assertDatabaseHas('posts', $data);
        $this->assertTrue($post->user->is($user));
    }
}
