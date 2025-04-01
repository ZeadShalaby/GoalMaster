<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tweets;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Share>
 */
class SharesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tweetss = Tweets::pluck('id')->toArray();
        $userids = User::pluck('id')->toArray();

        return [
            'tweet_id' => $this->faker->randomElement($tweetss),          
            'user_id' => $this->faker->randomElement($userids),
        ];

    }
}
