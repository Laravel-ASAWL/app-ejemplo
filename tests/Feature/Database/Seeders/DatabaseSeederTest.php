<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Database seeder runs successfully
     */
    public function test_database_seeder_runs_successfully()
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'name' => __('WASAL'),
            'email' => __('wasal@example.com'),
        ]);

        $this->assertDatabaseCount('users', 2001);
        $this->assertDatabaseCount('posts', 100);
        $this->assertDatabaseCount('comments', 2000);
    }
}
