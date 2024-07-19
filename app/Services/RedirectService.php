<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class RedirectService
{
    /**
     * Redirect to post with error message.
     */
    public function redirectToPostWithErrorMessage(Post $post, string $errorMessage): RedirectResponse
    {
        return redirect()
            ->route('posts.show', $post->slug)
            ->withErrors(['error' => $errorMessage])
            ->withFragment('comments')
            ->withInput();
    }

    /**
     * Redirect to post with success message.
     */
    public function redirectToPostWithSuccessMessage(Post $post, string $successMessage): RedirectResponse
    {
        return redirect()
            ->route('posts.show', $post->slug)
            ->with('success', $successMessage)
            ->withFragment('comments');
    }
}
