<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Follower;
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
        $categories = [
            'Movies',
            'Games',
            'Sports',
            'Politics',
            'Food',
            'Technology',
            'Travel',
            'Health',
            'Fashion',
            'Education',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        User::factory()->create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'username' => 'test',
            'bio' => 'Administrator | Developer | Photographer',
            'password' => Hash::make('1111'),
        ]);
        User::factory()->create([
            'name' => 'mary',
            'email' => 'mary@gmail.com',
            'username' => 'mary',
            'bio' => 'Administrator | Freelancer | Blogger',
            'password' => Hash::make('1111'),
        ]);
        User::factory()->create([
            'name' => 'zura',
            'email' => 'zura@gmail.com',
            'username' => 'zura',
            'bio' => 'Writer s | Filmmaker | Blogger',
            'password' => Hash::make('1111'),
        ]);

        Post::factory(50)->create();

        // $users = User::factory(10)->create();

        // // // Get users 1, 2, 3 (assuming they already exist)
        // $mainUsers = User::whereIn('id', [1, 2, 3])->get();

        // // Make all 100 users follow user 1, 2, and 3
        // foreach ($users as $user) {
        //     foreach ($mainUsers as $mainUser) {
        //         Follower::create([
        //             'user_id' => $mainUser->id, // the one being followed
        //             'follower_id' => $user->id, // follower
        //         ]);
        //     }
        // }

        // // Make users 1, 2, 3 follow 20 random users each
        // foreach ($mainUsers as $mainUser) {
        //     $following = $users->random(10);

        //     foreach ($following as $followedUser) {
        //         Follower::create([
        //             'user_id' => $followedUser->id,  // the one being followed
        //             'follower_id' => $mainUser->id,  // main user follows this user
        //         ]);
        //     }
        // }

    }
}
