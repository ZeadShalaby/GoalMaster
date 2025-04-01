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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("title")->unique();
            $table->string("description")->nullable();
            $table->string("status")->nullable();
            $table->date("due_dates")->nullable();
            $table->bigInteger('cat_id')->unsigned(); // ? cat => categories //
            $table->index('cat_id');
            $table->bigInteger('user_id')->unsigned(); 
            $table->index('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
