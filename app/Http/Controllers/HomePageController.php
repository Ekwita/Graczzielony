<?php

namespace App\Http\Controllers;

use App\Models\ArchivedRanking;
use Inertia\Inertia;

class HomePageController extends Controller
{
    public function index()
    {
        $recentWinners = ArchivedRanking::with('games')
            ->orderByDesc('month')
            ->take(3)
            ->get();

        return Inertia::render('Welcome', [
            'recentWinners' => $recentWinners,
        ]);
    }
}
