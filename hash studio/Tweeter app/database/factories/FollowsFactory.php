<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userids = User::pluck('id')->toArray();

        return [
            'following_id' => $this->faker->randomElement($userids),          
            'followers_id' => $this->faker->randomElement($userids),
        ];

    }
}
