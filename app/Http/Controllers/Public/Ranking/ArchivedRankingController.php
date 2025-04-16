<?php

namespace App\Http\Controllers\Public\Ranking;

use App\Http\Controllers\Controller;
use App\Models\ArchivedRanking;
use Inertia\Inertia;
use Inertia\Response;

class ArchivedRankingController extends Controller
{
    public function index(): Response
    {
        $rankings = ArchivedRanking::orderByDesc('month')->get();

        return Inertia::render('ranking/Archive', [
            'rankings' => $rankings,
        ]);
    }

    public function show(int $id): Response
    {
        $ranking = ArchivedRanking::with('games')->findOrFail($id);

        return Inertia::render('ranking/ArchiveShow', [
            'ranking' => $ranking
        ]);
    }
}
