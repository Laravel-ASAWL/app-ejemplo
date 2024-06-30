<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::createFromTimestamp(rand(Carbon::now()->subYears(1)->timestamp, Carbon::now()->timestamp));

        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'body' => fake()->sentences(5, true),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
