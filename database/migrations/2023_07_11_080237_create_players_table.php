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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('second_name', 64);
            $table->unsignedInteger('league_id');
            $table->integer('points');
            $table->integer('balance');
            $table->integer('legs_won');
            $table->integer('legs_lost');
            $table->double('average_3_dart', 3, 2);
            $table->integer('max_amount');
            $table->timestamps();

            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
