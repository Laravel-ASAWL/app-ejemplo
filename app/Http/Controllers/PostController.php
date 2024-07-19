<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\PostLogger;
use App\Services\RedirectService;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private PostRepository $postRepository,
        private PostLogger $logger,
        private RedirectService $redirectService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = $this->postRepository->posts();

        return view('posts.index', $posts);
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
            $this->logger->logPostNotFound($slug);

            return abort(404);
        }

        $comments = $this->postRepository->postComments($post);

        return $this->redirectService->redirectToPostWithComments($post, $comments);
    }
}
