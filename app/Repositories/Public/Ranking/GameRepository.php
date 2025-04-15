<?php

namespace App\Repositories\Public\Ranking;

use App\Models\Game;

class GameRepository
{
    public function findOrCreate(array $voteData): Game
    {
        $game = Game::firstOrCreate(
            ['bgg_id' => $voteData['id']],
            [
                'name' => $voteData['name'],
                'hyperlink' => 'https://boardgamegeek.com/boardgame/' . $voteData['id'],
                'score' => 0,
                'image' => $voteData['image'],
                'votes' => 0,
            ]
        );

        return $game;
    }

    public function incrementStats(Game $game, array $voteData): void
    {
        $game->increment('votes');
        $game->increment('score', $voteData['points']);
    }
}
