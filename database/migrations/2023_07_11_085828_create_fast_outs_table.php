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
        Schema::create('fast_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fast_out_type_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('game_id');
            $table->timestamps();

            $table->foreign('fast_out_type_id')->references('id')->on('fast_out_types')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fast_outs');
    }
};
