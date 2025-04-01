<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'username' => Str::slug($this->faker->name()) . '_' . strtoupper(Str::random(3)),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Default password
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birthday' => $this->faker->dateTimeBetween('-30 years', 'now'),
        ];
    }

    /**
     * Configure the factory with relationships.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $img = ["images/users/kk.png","images/users/sunset.png","images/users/byden.png","images/users/tweet.png"];
            $increment = random_int(0,3);
            $user->media()->create([
                'media' => $img[$increment],
            ]);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
