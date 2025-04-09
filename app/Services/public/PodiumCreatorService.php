<?php

namespace App\Services\Public;

use App\Models\Game;
use App\Models\Podium;

class PodiumCreatorService
{
    public function createPodium()
    {
        $games = Game::orderByDesc('score')
            ->orderByDesc('votes')
            ->limit(3)
            ->get();
        foreach ($games as $game) {
            Podium::create([]);
        }
    }

    public function archiveRanking()
    {
        //
    }

    public function clearScore()
    {
        $games = Game::all();
        foreach ($games as $game) {
            $game->score = 0;
            $game->save();
        }
    }
}
