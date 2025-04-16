<?php

namespace App\Actions;

use App\Models\ArchivedGame;
use App\Models\ArchivedRanking;
use App\Models\Game;
use App\Models\Vote;
use Carbon\Carbon;

class ArchiveTopGames
{
    public function __invoke(): void
    {
        $now = Carbon::now();
        $month = $now->subMonth()->format('Y-m');

        // Wyciągnięcie wszystkich gier z wynikiem > 0, posortowane
        $games = Game::where('score', '>', 0)
            ->orderByDesc('score')
            ->orderByDesc('votes')
            ->get();

        // Ustalenie pozycji z uwzględnieniem remisów
        $rankedGames = [];
        $position = 1;
        $lastScore = null;
        $lastVotes = null;
        $count = 0;

        foreach ($games as $game) {
            $count++;
            if ($lastScore !== null && ($game->score !== $lastScore || $game->votes !== $lastVotes)) {
                $position = $count;
            }

            $rankedGames[] = [
                'game' => $game,
                'position' => $position,
            ];

            $lastScore = $game->score;
            $lastVotes = $game->votes;
        }

        // Wyznaczenie zwycięzców (pozycja == 1)
        $winners = collect($rankedGames)->filter(fn($g) => $g['position'] === 1)->pluck('game');

        $newArchivedRanking = ArchivedRanking::create([
            'winner_name' => $winners->pluck('name')->join(', '),
            'winner_image' => $winners->first()->image, // np. tylko jeden obrazek
            'month' => $month,
        ]);

        // Tylko Top 10 miejsc (nie gier!), uwzględniając remisy
        $top10Positions = collect($rankedGames)->unique('position')->take(10)->pluck('position');

        foreach ($rankedGames as $entry) {
            if (!$top10Positions->contains($entry['position'])) continue;

            ArchivedGame::create([
                'ranking_id' => $newArchivedRanking->id,
                'position' => $entry['position'],
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

    private function clearData()
    {
        Vote::truncate();
        Game::query()->update([
            'votes' => 0,
            'score' => 0,
        ]);
    }
}
