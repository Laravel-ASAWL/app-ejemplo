<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::factory();
        $title = fake()->sentence();
        $slug = Str::slug($title);
        $description = fake()->paragraphs(3, true);
        $body = file_get_contents(database_path("factories/fixtures/post-". rand(1,10) .".md"));
        $date = Carbon::createFromTimestamp(rand(Carbon::now()->subYears(1)->timestamp, Carbon::now()->timestamp));;

        return [
            'user_id' => $user_id,
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'body' => $body,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
