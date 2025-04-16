<?php

namespace App\Http\Controllers\Public\Ranking;

use App\Http\Controllers\Controller;
use App\Services\Public\Ranking\GamesRankingService;
use Inertia\Inertia;
use Inertia\Response;

class RankingController extends Controller
{

    public function __construct(
        protected GamesRankingService $gamesRankingService,
    ) {}
    
    public function index(): Response
    {
        $rankedGames = $this->gamesRankingService->showRanking();

        return Inertia::render('ranking/CurrentRanking', [
            'games' => $rankedGames,
        ]);
    }
}
