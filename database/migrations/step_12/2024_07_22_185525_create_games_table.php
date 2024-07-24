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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('opponent');
            $table->string('place')->comment('試合会場|home or visitor');
            $table->integer('match_number')->nullable()->comment('何試合目か');
            $table->integer('score_us')->nullable()->comment('自チーム得点');
            $table->integer('score_opponent')->nullable()->comment('相手チーム得点');
            $table->string('result')->nullable();
            $table->string('comment')->nullable();
            $table->string('game_score_book_1')->nullable();
            $table->string('game_score_book_2')->nullable();
            $table->timestamps();
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
