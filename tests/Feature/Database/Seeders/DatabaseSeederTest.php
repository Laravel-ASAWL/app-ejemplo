<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test database seeder runs successfully
     */
    public function test_database_seeder_runs_successfully()
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'name' => __('WASAL'),
            'email' => __('asawl@example.com'),
        ]);

        $this->assertDatabaseCount('users', 2501);
        $this->assertDatabaseCount('posts', 50);
        $this->assertDatabaseCount('comments', 2500);
    }
}
