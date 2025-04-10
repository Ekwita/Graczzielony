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
        Schema::create('archived_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_id')->constrained('archived_rankings')->onDelete('cascade');
            $table->unsignedTinyInteger('position');
            $table->string('game_name');
            $table->string('game_image')->nullable();
            $table->string('bgg_id')->nullable();
            $table->string('hyperlink')->nullable();
            $table->unsignedInteger('score');
            $table->unsignedInteger('votes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_games');
    }
};
