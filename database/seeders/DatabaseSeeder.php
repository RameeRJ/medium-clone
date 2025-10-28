<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = ['Technology', 'Health', 'Travel', 'Education', 'Lifestyle'];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        User::factory()->create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'username' => 'test',
            'password' => Hash::make('1111'),
        ]);

        // Post::factory(50)->create();
    }
}
