<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //// todo add one customer ////
        $defCustomer = User::factory()->create([  
            'name' => 'Customer',
            'username' => 'Customer Login',
            'gmail' => 'customer@gmail.com',
            'password' => Hash::make('customer'), 
        ]);

        //// todo add Categories ////
        $cat1 = Categories::factory()->create([  
            'name' => 'Cat Work',
            'photo' => '/api/cat/imagecat/work.png',
        ]);

        //// todo add Categories 2 ////
        $cat2 = Categories::factory()->create([  
            'name' => 'Cat personal',
            'photo' => '/api/cat/imagecat/personal.png',
        ]);

        //// todo add Categories 3 ////
        $cat3 = Categories::factory()->create([  
            'name' => 'Cat urgent',
            'photo' => '/api/cat/imagecat/urgent.png',
        ]);

        //// todo add users  ////
        $customer = User::factory()
        ->count(19)
        ->create();

    }
}
