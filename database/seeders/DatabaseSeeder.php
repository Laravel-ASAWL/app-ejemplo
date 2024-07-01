<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'asawl',
            'email' => 'asawl@ejemplo.com',
            'password' => '@Asawl1234*',
        ]);
        Post::factory(50)->has(Comment::factory(50))->for($user)->create();
    }
}
