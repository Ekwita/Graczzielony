<?php

namespace App\Services\Public\Ranking;

use App\Models\Game;
use Illuminate\Support\Collection;

class RankingCalculator
{
    /**
     * Assigns competition-style places (1, 2, 2, 4, ...) to a list of games
     * already sorted by (score desc, votes desc).
     *
     * @param  iterable<int, Game>  $games
     * @return Collection<int, array{place: int, game: Game}>
     */
    public function rank(iterable $games): Collection
    {
        $ranked = collect();
        $place = 0;
        $position = 0;
        $previous = null;

        foreach ($games as $game) {
            $position++;

            if ($previous === null || $game->score !== $previous->score || $game->votes !== $previous->votes) {
                $place = $position;
            }

            $ranked->push(['place' => $place, 'game' => $game]);
            $previous = $game;
        }

        return $ranked;
    }

    /**
     * Keeps every entry whose place falls within the first $limit distinct places.
     *
     * @param  Collection<int, array{place: int, game: Game}>  $ranked
     * @return Collection<int, array{place: int, game: Game}>
     */
    public function limitToTopPlaces(Collection $ranked, int $limit): Collection
    {
        $topPlaces = $ranked->pluck('place')->unique()->take($limit);

        return $ranked->filter(fn (array $entry) => $topPlaces->contains($entry['place']))->values();
    }
}
