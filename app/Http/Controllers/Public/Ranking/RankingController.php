<?php

namespace App\Http\Controllers\Public\Ranking;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Inertia\Inertia;

class RankingController extends Controller
{
    public function index()
    {
        return Inertia::render('ranking/CurrentRanking', [
            'games' => Game::where('score', '>', 0)
                ->where('votes', '>', 0)->orderByDesc('score')
                ->orderByDesc('votes')
                ->take(10)
                ->get()
        ]);
    }
}
