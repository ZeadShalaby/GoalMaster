<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\Tweets;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tweet>
 */
class TweetsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();

        return [
            'description' => $this->faker->text(),
            'user_id' => $this->faker->randomElement($userIds),
            'view' => $this->faker->boolean() ? $this->faker->numberBetween(1, 10) : null,
            'report' => null,
            'explore' => $this->faker->boolean() ? $this->faker->numberBetween(10, 50) : null,
        ];
    }

    /**
     * Configure the factory with relationships.
     *
     * @return $this
     */
    public function configure()
    {
        
        return $this->afterCreating(function (Tweets $tweet) {
            $img = ["images/tweets/kk.png","images/tweets/sunset.png","images/tweets/byden.png","images/tweets/tweet.png"];
            $increment = random_int(0,3);

            if ($this->faker->boolean()) {
                $tweet->media()->create([
                    'media' => $img[$increment],
                ]);
            }
        });
    }
   


}
