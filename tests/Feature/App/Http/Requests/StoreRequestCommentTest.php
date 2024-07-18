<?php

namespace Tests\Feature\App\Http\Requests;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreRequestCommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Authorized user can create comment.
     */
    public function test_authorized_user_can_create_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('posts.comments.store', $post), [
                'body' => $this->faker->paragraph,
            ])
            ->assertValid();
    }

    /**
     * Unauthorized user cannot create comment.
     */
    public function test_unauthorized_user_cannot_create_comment()
    {
        $post = Post::factory()->create();

        $this->post(route('posts.comments.store', $post), [
            'body' => $this->faker->paragraph,
        ])->assertRedirect(route('login'));
    }

    /**
     * Comment body is required.
     */
    public function test_comment_body_is_required()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('posts.comments.store', $post), [])
            ->assertInvalid(['body']);
    }

    /**
     * Comment body must be a string.
     */
    public function test_comment_body_must_be_a_string()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('posts.comments.store', $post), ['body' => 123])
            ->assertInvalid(['body']);
    }

    /**
     * Comment body must be at least 25 characters.
     */
    public function test_body_field_must_be_at_least_25_characters()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('posts.comments.store', $post), ['body' => 'Too short'])
            ->assertInvalid(['body']);
    }

    /**
     * Comment body cannot exceed 255 characters.
     */
    public function test_body_field_cannot_exceed_255_characters()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('posts.comments.store', $post), ['body' => $this->faker->paragraphs(10, true)])
            ->assertInvalid(['body']);
    }
}
