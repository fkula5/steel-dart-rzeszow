<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_one');
            $table->unsignedBigInteger('player_two');
            $table->integer('player_one_score');
            $table->integer('player_two_score');
            $table->double('player_one_avg', 3, 2);
            $table->double('player_two_avg', 3, 2);
            $table->integer('player_one_max_amount');
            $table->integer('player_two_max_amount');
            $table->unsignedBigInteger('league_id');
            $table->unsignedBigInteger('winner');
            $table->timestamps();

            $table->foreign('player_one')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('player_two')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('winner')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
