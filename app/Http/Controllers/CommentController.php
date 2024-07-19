<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestComment;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\CommentRepository;
use App\Services\CommentLogger;
use App\Services\RedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

/**
 * Comment controller.
 */
class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private CommentRepository $commentRepository,
        private CommentLogger $logger,
        private RedirectService $redirectService
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestComment $request, Post $post): RedirectResponse
    {
        if (! Gate::allows('auth', Comment::class)) {
            $this->logger->logUnauthorizedCreationAttempt($post, $request->validated('body'));

            return $this->redirectService->redirectToPostWithErrorMessage($post, __('You are not authorized to create comments.'));
        }

        if (! Gate::allows('verificateEmail', Comment::class)) {
            $this->logger->logUnverifiedEmailCreationAttempt($post, $request->validated('body'));

            return $this->redirectService->redirectToPostWithErrorMessage(
                $post,
                __('You have not verified your email address.').' '.
                '<a href="'.route('verification.notice').'" class="underline">'.
                __('Click here to verify your email address').'</a>.'
            );
        }

        $comment = $this->commentRepository->create($post, [
            'user_id' => auth()->user()->id,
            'body' => $request->validated('body'),
        ]);

        $this->logger->logCommentCreated($post, $comment);

        return $this->redirectService->redirectToPostWithSuccessMessage($post, __('Comment created successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment): RedirectResponse
    {
        if (! Gate::allows('auth', Comment::class)) {
            $this->logger->logUnauthorizedDeletionAttempt($post, $comment);

            return $this->redirectService->redirectToPostWithErrorMessage($post, __('You are not authorized to delete comments.'));
        }

        if (! Gate::allows('verificateEmail', Comment::class)) {
            $this->logger->logUnverifiedEmailDeletionAttempt($post, $comment);

            return $this->redirectService->redirectToPostWithErrorMessage(
                $post,
                __('You have not verified your email address.').' '.
                '<a href="'.route('verification.notice').'" class="underline">'.
                __('Click here to verify your email address').'</a>.'
            );
        }

        if ((! Gate::allows('ownerComment', $comment) && (! Gate::allows('ownerPost', $comment)))) {
            $this->logger->logUnauthorizedDeletionAttempt($post, $comment);

            return $this->redirectService->redirectToPostWithErrorMessage($post, __('You are not authorized to delete comments.'));
        }

        $this->commentRepository->delete($comment);

        $this->logger->logCommentDeleted($post, $comment);

        return $this->redirectService->redirectToPostWithSuccessMessage($post, __('Comment deleted successfully!'));
    }
}
