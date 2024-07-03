<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\DatabaseSeeder;
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
            'name' => 'asawl',
            'email' => 'asawl@ejemplo.com',
        ]);

        $this->assertDatabaseCount('posts', 50);
        $this->assertDatabaseCount('comments', 2500);
    }
}
