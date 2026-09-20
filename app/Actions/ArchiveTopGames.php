<?php

namespace App\Actions;

use App\Models\ArchivedGame;
use App\Models\ArchivedRanking;
use App\Models\Game;
use App\Models\Vote;
use App\Services\Public\Ranking\RankingCalculator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ArchiveTopGames
{
    public function __construct(
        protected RankingCalculator $rankingCalculator,
    ) {}

    public function __invoke(): void
    {
        $month = Carbon::now()->subMonth()->format('Y-m');

        $ranked = $this->rankingCalculator->rank($this->orderedGames());
        $topRanked = $this->rankingCalculator->limitToTopPlaces($ranked, 10);

        $winners = $ranked->where('place', 1)->pluck('game');

        $archivedRanking = ArchivedRanking::create([
            'winner_name' => $winners->pluck('name')->join(', '),
            'winner_image' => $winners->first()?->image,
            'month' => $month,
        ]);

        foreach ($topRanked as $entry) {
            ArchivedGame::create([
                'ranking_id' => $archivedRanking->id,
                'position' => $entry['place'],
                'game_name' => $entry['game']->name,
                'game_image' => $entry['game']->image,
                'bgg_id' => $entry['game']->bgg_id,
                'hyperlink' => $entry['game']->hyperlink,
                'score' => $entry['game']->score,
                'votes' => $entry['game']->votes,
            ]);
        }

        $this->clearData();
    }

    private function orderedGames(): Collection
    {
        return Game::where('score', '>', 0)
            ->orderByDesc('score')
            ->orderByDesc('votes')
            ->get();
    }

    private function clearData(): void
    {
        Vote::truncate();
        Game::query()->update([
            'votes' => 0,
            'score' => 0,
        ]);
    }
}
