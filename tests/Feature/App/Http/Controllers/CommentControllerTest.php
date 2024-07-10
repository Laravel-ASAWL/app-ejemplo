<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Authorized user can create a comment
     */
    public function test_authorized_user_can_create_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'This is a test comment with more than 25 characters.',
        ]);

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHas('success', __('Comment created successfully!'));
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => 'This is a test comment with more than 25 characters.',
        ]);
    }

    /**
     * Unauthorized user cannot create a comment
     */
    public function test_unauthorized_user_cannot_create_comment()
    {
        $user = User::factory()->unverified()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'This comment should not be created because the email address of the user is not verified',
        ]);

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHas('errors', [__('You are not authorized to create comments.')]);
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * Comment creation fails without body
     */
    public function test_comment_creation_fails_without_body()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), ['body' => null]);

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHasErrors(['body' => __('A comment is required.')]);
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * Comment creation fails without body type string
     */
    public function test_comment_creation_fails_without_body_type_string()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), ['body' => 1234567890]);

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHasErrors(['body' => __('The comment must be text.')]);
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * Comment creation fails with too short text
     */
    public function test_comment_creation_fails_with_too_short_text()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'Comment too short.',
        ]);

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHasErrors(['body' => __('The comment must be at least 25 characters long.')]);
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * Comment creation fails with too long text
     */
    public function test_comment_creation_fails_with_too_long_text()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'This comment should not be created because the text is too long.'.
                ' It should be at most 255 characters long but it is more then 255 characters long.'.
                ' This comment should not be created because the text is too long.'.
                ' It should be at most 255 characters long but it is more then 255 characters long.'.
                ' This comment should not be created because the text is too long.'.
                ' It should be at most 255 characters long but it is more then 255 characters long.',
        ]);

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHasErrors(['body' => __('The comment cannot exceed 255 characters.')]);
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * Authorized user can delete own comment
     */
    public function test_authorized_user_can_delete_own_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();

            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHas('success', __('Comment deleted successfully!'));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /**
     * Authorized user can delete comment of own post
     */
    public function test_authorized_user_can_delete_comment_of_own_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();

            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHas('success', __('Comment deleted successfully!'));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /**
     * Unauthorized user cannot delete comment
     */
    public function test_unauthorized_user_cannot_delete_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();

            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertRedirectContains(route('posts.show', $post->slug).'#comments');
        $response->assertSessionHas('errors', [__('You are not authorized to delete comments.')]);
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    /**
     * Non-existent comment cannot be deleted
     */
    public function test_nonexistent_comment_cannot_be_deleted()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();

            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, 999]));

        $response->assertNotFound();
    }

    /**
     * Exception during delete comment
     */
    public function test_exception_during_delete_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();

            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        Comment::where('id', $comment->id)->delete();
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertNotFound();
    }
}
