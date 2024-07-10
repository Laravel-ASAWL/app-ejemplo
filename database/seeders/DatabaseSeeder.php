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
            'name' => __('WASAL'),
            'email' => __('asawl@example.com'),
            'password' => '@Asawl1234*',
        ]);

        Post::factory(100)->has(Comment::factory(20))->for($user)->create();
        //Post::factory(100)->for($user)->create();
    }
}
