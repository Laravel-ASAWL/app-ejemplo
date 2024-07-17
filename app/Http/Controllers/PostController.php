<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('posts.index', [
            'posts' => Post::count() > 0 ? Post::latest()
                ->select('title', 'slug', 'description', 'created_at')
                ->paginate(10) : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)
            ->select('id', 'user_id', 'title', 'slug', 'description', 'body', 'created_at')
            ->with('user:id,name,email')
            ->first();

        if (is_null($post)) {
            Log::error(__('Post not found.'), ['post_slug' => $slug]);

            return abort(404);
        }

        return view('posts.show', [
            'post' => $post,
            'comments' => $post->comments()->count() > 0 ? $post->comments()->latest()
                ->select('id', 'user_id', 'post_id', 'body', 'created_at')
                ->with('user:id,name,email')
                ->paginate(10) : null,
        ]);
    }
}
