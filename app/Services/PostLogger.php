<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class PostLogger
{
    /**
     * Log a post not found.
     *
     * @param  string  $commentBody
     */
    public function logPostNotFound(string $slug): void
    {
        Log::warning(__('Post not found'), [
            'ip_address' => Request::ip(),
            'user_id' => auth()->user()->id ?? 'Unknown',
            'post_slug' => $slug,
        ]);
    }
}
