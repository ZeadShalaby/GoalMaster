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
        Schema::create('users', function (Blueprint $table) {
            $table->id();// ! to start in value ->startingValue(1755) //
            $table->string('name');
            $table->string('username')->unique();
            $table->string('gmail')->nullable();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->bigInteger('phone')->unique()->nullable();
            $table->index('phone');
            $table->date('birthday')->nullable();
            $table->timestamps();
            $table->string("avatar")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
