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
            'games' => Game::orderByDesc('score')
                ->orderByDesc('votes')
                ->limit(10)
                ->get()
        ]);
    }
}
