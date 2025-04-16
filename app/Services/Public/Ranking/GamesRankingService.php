<?php

namespace App\Services\Public\Ranking;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class GamesRankingService
{
    public function showRanking(): array
    {
        $games = $this->orderGames();

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

        return $rankedGames;
    }

    private function orderGames(): Collection
    {
        return Game::where('score', '>', 0)
            ->where('votes', '>', 0)
            ->orderByDesc('score')
            ->orderByDesc('votes')
            ->get();
    }
}
