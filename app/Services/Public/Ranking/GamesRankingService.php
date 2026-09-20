<?php

namespace App\Services\Public\Ranking;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class GamesRankingService
{
    public function __construct(
        protected RankingCalculator $rankingCalculator,
    ) {}

    public function showRanking(): array
    {
        $ranked = $this->rankingCalculator->rank($this->orderedGames());
        $visible = $this->rankingCalculator->limitToTopPlaces($ranked, 10);

        return $visible->map(fn (array $entry) => [
            'place' => $entry['place'],
            'name' => $entry['game']->name,
            'score' => $entry['game']->score,
            'votes' => $entry['game']->votes,
            'image' => $entry['game']->image,
            'hyperlink' => $entry['game']->hyperlink,
        ])->all();
    }

    private function orderedGames(): Collection
    {
        return Game::where('score', '>', 0)
            ->where('votes', '>', 0)
            ->orderByDesc('score')
            ->orderByDesc('votes')
            ->get();
    }
}
