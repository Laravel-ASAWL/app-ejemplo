<?php

namespace Tests\Feature\Routes;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index page can be loaded.
     */
    public function test_index_page_can_be_loaded(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    /**
     * Show page can be loaded.
     */
    public function test_show_page_can_be_loaded(): void
    {
        $post = Post::factory()->create();
        $response = $this->get(route('posts.show', $post->slug));

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
    }

    /**
     * User can access the dashboard.
     */
    public function test_user_can_access_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /**
     * Guest cannot access the dashboard.
     */
    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * User can access the posts page.
     */
    public function test_authenticated_user_can_create_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'This is a test comment with more than 25 characters.',
        ]);

        $response->assertStatus(302);
        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $this->assertDatabaseCount('comments', 1);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => 'This is a test comment with more than 25 characters.',
        ]);
    }

    /**
     * Unauthenticated user cannot create a comment.
     */
    public function test_unauthenticated_user_cannot_create_comment()
    {
        $post = Post::factory()->create();

        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'This is a test comment with more than 25 characters.',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * Authenticated user can delete own comment.
     */
    public function test_authenticated_user_can_delete_own_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertStatus(302);
        $response->assertRedirect(route('posts.show', $post).'#comments');
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * Authenticated user cannot delete other users comment.
     */
    public function test_authenticated_user_cannot_delete_other_users_comment()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user1->id]);
        $this->actingAs($user2);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertStatus(302);
        $response->assertRedirect(route('posts.show', $post).'#comments');
        $this->assertDatabaseCount('comments', 1);
        $this->assertModelExists($comment);
    }
}
