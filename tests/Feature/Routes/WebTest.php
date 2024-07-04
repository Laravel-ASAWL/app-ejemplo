<?php

namespace Tests\Feature\Routes;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
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
    }
}
