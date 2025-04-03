<?php

namespace App\Services\Public;

use App\Models\Game;

class PodiumCreatorService
{
    public function createPodium()
    {
        $games = Game::orderByDesc('score')
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
