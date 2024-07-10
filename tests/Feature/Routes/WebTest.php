<?php

namespace Tests\Feature\Routes;

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
    }
}
