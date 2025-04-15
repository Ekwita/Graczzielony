<?php

namespace App\Services\Public\Ranking;

use App\Repositories\Public\Ranking\GameRepository;
use App\Repositories\Public\Ranking\VoteReposiory;

class VoteService
{

    public function __construct(
        protected GameRepository $gameRepository,
        protected VoteReposiory $voteReposiory,
    ) {}

    public function storeVote(array $validated): void
    {
        foreach ($validated['votes'] as $voteData) {
            $game = $this->gameRepository->findOrCreate($voteData);
            $this->gameRepository->incrementStats($game, $voteData);
            $this->voteReposiory->create($voteData, $game, $validated['username']);
        }
    }
}
