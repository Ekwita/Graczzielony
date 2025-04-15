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

        $bestGame = Game::orderByDesc('score')
            ->orderByDesc('votes')
            ->first();

        $now = Carbon::now();
        $month = $now->subMonth()->format('Y-m');

        $newArchivedRanking =  ArchivedRanking::create([
            'winner_name' => $bestGame->name,
            'winner_image' => $bestGame->image,
            'month' => $month,
        ]);

        $topGames = Game::orderByDesc('score')
            ->orderByDesc('votes')
            ->take(10)
            ->get();

        foreach ($topGames as $index => $games) {
            ArchivedGame::create([
                'ranking_id' => $newArchivedRanking->id,
                'position' => $index + 1,
                'game_name' => $games->name,
                'game_image' => $games->image,
                'bgg_id' => $games->bgg_id,
                'hyperlink' => $games->hyperlink,
                'score' => $games->score,
                'votes' => $games->votes,
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
