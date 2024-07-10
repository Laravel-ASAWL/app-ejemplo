<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return View
     */
    public function index(): View
    {
        return view('posts.index', [
            'posts' => Post::count() > 0 ? Post::latest()->with('user')->paginate(10) : null,
        ]);
    }

    /**
     * Display the specified resource.
     * 
     * @param string $slug
     * 
     * @return View
     */
    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('posts.show', [
            'post' => $post,
            'comments' => $post->comments()->count() > 0 ? $post->comments()->latest()->with('user')->paginate(10) : null,
        ]);
    }
}
