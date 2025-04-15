<?php

namespace App\Http\Controllers\Public\Ranking;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Inertia\Inertia;
use Inertia\Response;

class RankingController extends Controller
{
    public function index(): Response
    {
        $games = Game::where('score', '>', 0)
            ->where('votes', '>', 0)
            ->orderByDesc('score')
            ->orderByDesc('votes')
            ->get();

        $rankedGames = [];
        $currentPlace = 1;
        $sameRankCount = 1;
        $lastVisiblePlace = 0;

        foreach ($games as $index => $game) {
            if ($index > 0) {
                $prev = $games[$index - 1];

                if ($game->score === $prev->score && $game->votes === $prev->votes) {
                    $place = $currentPlace;
                    $sameRankCount++;
                } else {
                    $currentPlace += $sameRankCount;
                    $place = $currentPlace;
                    $sameRankCount = 1;
                }
            } else {
                $place = $currentPlace;
            }

            if ($place > 10 && $place !== $lastVisiblePlace) {
                break;
            }

            $rankedGames[] = [
                'place' => $place,
                'name' => $game->name,
                'score' => $game->score,
                'votes' => $game->votes,
                'image' => $game->image,
                'hyperlink' => $game->hyperlink,
            ];

            $lastVisiblePlace = $place;
        }

        return Inertia::render('ranking/CurrentRanking', [
            'games' => $rankedGames,
        ]);
    }
}
