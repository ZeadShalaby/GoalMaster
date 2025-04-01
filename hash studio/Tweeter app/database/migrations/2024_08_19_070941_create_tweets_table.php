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
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->string("description")->nullable();
            $table->bigInteger('view')->unsigned()->nullable();
            $table->index('view');
            $table->bigInteger('user_id')->unsigned(); 
            $table->index('user_id');
            $table->bigInteger('report')->unsigned()->nullable();
            $table->index('report');
            $table->bigInteger('explore')->unsigned()->nullable();
            $table->index('explore');
            $table->timestamps();        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
