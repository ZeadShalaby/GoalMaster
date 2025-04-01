<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

            // ? tweet table relation
            Schema::table('tweets', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users');                
            });

            // ? favourites table relation
            Schema::table('favourites', function (Blueprint $table) {
                $table->foreign('tweet_id')->references('id')->on('tweets');                
                $table->foreign('user_id')->references('id')->on('users');                
            });

            
            // ? likes table relation
            Schema::table('likes', function (Blueprint $table) {
                $table->foreign('tweet_id')->references('id')->on('tweets');                
                $table->foreign('user_id')->references('id')->on('users');                
            });
            
            // ? follow table relation
            Schema::table('follows', function (Blueprint $table) {
                $table->foreign('following_id')->references('id')->on('users');                
                $table->foreign('followers_id')->references('id')->on('users');                
            });

            // ? share table relation
            Schema::table('shares', function (Blueprint $table) {
                $table->foreign('tweet_id')->references('id')->on('tweets');                
                $table->foreign('user_id')->references('id')->on('users');                
            });
    

    }

    /**->onDelete('cascade');
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
