<?php

namespace Database\Factories;

use App\Models\Category;
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

        $title = fake()->sentence();

        return [
            'image' => fake()->imageUrl(640, 480, 'tech', true), // optional: you can specify dimensions and category
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => implode("\n\n", fake()->paragraphs(5)), // convert array to string
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => 1,
            'published_at' => optional(fake()->optional()->dateTime())->format('Y-m-d H:i:s'),
        ];
    }
}
