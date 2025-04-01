<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Likes;
use App\Models\Shares;
use App\Models\Follows;
use App\Models\Tweets;
use App\Models\Favourite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        $defCustomer = User::factory()->create([
                'username' => 'user',
                'email' => 'user@test.com',
                'password' => Hash::make('user'), 
            ]); 

        //? Create 10 tweets
        $tweets = Tweets::factory()->count(10)->create();

        //? Create 10 tweets
        $customer = User::factory()
        ->count(9)
        ->create();
        $customer->push($defCustomer);

        //? create 10 favourite tweets
        $favourite = Favourite::factory()
        ->count(10)
        ->state(function (array $attributes) use ($tweets, $customer) {
            return [
                'tweet_id' => $tweets->random()->id,
                'user_id' => $customer->random()->id,
            ];
        })->create();


        //? create 10 favourite tweets
        $favourite = Follows::factory()
        ->count(10)
        ->state(function (array $attributes) use ($customer) {
            return [
                'following_id' => $customer->random()->id,
                'followers_id' => $customer->random()->id,
            ];
        })->create();

        //? create 10 Shares tweets
        $favourite = Shares::factory()
        ->count(10)
        ->state(function (array $attributes) use ($tweets, $customer) {
            return [
                'tweet_id' => $tweets->random()->id,
                'user_id' => $customer->random()->id,
            ];
        })->create();


        //? create 30 Likes tweets
        $favourite = Likes::factory()
        ->count(30)
        ->state(function (array $attributes) use ($tweets, $customer) {
            return [
                'tweet_id' => $tweets->random()->id,
                'user_id' => $customer->random()->id,
            ];
        })->create();


    }
}
