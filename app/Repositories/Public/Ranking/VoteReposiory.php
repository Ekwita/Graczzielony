<?php

namespace App\Repositories\Public\Ranking;

use App\Models\Game;
use App\Models\Vote;

class VoteReposiory
{
    public function create(array $voteData, Game $game, string $username): void
    {
        Vote::create([
            'game_id' => $game->id,
            'points' => $voteData['points'],
            'user_name' => $username,
            'email' => 'user@user.com',
            'voted_at' => now(),
        ]);
    }
}
