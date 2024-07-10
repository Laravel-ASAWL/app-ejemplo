<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws mixed
     */
    public function store(Request $request, Post $post)
    {
        try {
            $this->authorize('create', Comment::class);

            $data = $request->validate([
                'body' => [
                    'required',
                    'string',
                    'min:25',
                    'max:255',
                ],
            ], [
                'body.required' => __('A comment is required.'),
                'body.string' => __('The comment must be text.'),
                'body.min' => __('The comment must be at least 25 characters long.'),
                'body.max' => __('The comment cannot exceed 255 characters.'),
            ]);

            $post->comments()->create([
                'user_id' => $request->user()->id,
                'post_id' => $post->id,
                'body' => $data['body'],
            ]);

            return to_route('posts.show', $post->slug)
                ->with('success', __('Comment created successfully!'))
                ->withFragment('comments');
        } catch (AuthorizationException $e) {
            return to_route('posts.show', $post->slug)
                ->withInput()
                ->with('errors', [__('You are not authorized to create comments.')])
                ->withFragment('comments');
        } catch (ValidationException $e) {
            return to_route('posts.show', $post->slug)
                ->withInput()
                ->withErrors($e->validator)
                ->withFragment('comments');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws mixed
     */
    public function destroy(Post $post, Comment $comment)
    {
        try {
            $this->authorize('delete', $comment, $post);

            $comment->delete();

            return to_route('posts.show', $post->slug)
                ->with('success', __('Comment deleted successfully!'))
                ->withFragment('comments');
        } catch (AuthorizationException $e) {
            return to_route('posts.show', $post->slug)
                ->withInput()
                ->with('errors', [__('You are not authorized to delete comments.')])
                ->withFragment('comments');
        }
    }
}
