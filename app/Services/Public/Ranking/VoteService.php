<?php

namespace App\Services\Public\Ranking;

use App\Repositories\Public\Ranking\GameRepository;
use App\Repositories\Public\Ranking\VoteRepository;

class VoteService
{
    public function __construct(
        protected GameRepository $gameRepository,
        protected VoteRepository $voteRepository,
    ) {}

    public function storeVote(array $validated): void
    {
        foreach ($validated['votes'] as $voteData) {
            $game = $this->gameRepository->findOrCreate($voteData);
            $this->gameRepository->incrementStats($game, $voteData);
            $this->voteRepository->create($voteData, $game, $validated['username']);
        }
    }
}
