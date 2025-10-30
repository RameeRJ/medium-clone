<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $roles = [
            'Freelancer',
            'Web Developer',
            'Graphic Designer',
            'UI/UX Designer',
            'Content Creator',
            'Photographer',
            'Cyber Security Engineer',
            'Data Analyst',
            'AI Enthusiast',
            'Digital Marketer',
            'Writer',
            'Filmmaker',
            'Software Engineer',
            'App Developer',
            'Blockchain Developer',
            'Musician',
            'Entrepreneur',
            'Researcher',
        ];

        $randomRoles = collect($roles)->random(rand(2, 4))->implode(' | ');

        return [
            'name' => $name,
            'username' => Str::slug($name).fake()->unique()->numberBetween(100, 9999),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'bio' => $randomRoles,
            'password' => static::$password ??= Hash::make('1111'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
