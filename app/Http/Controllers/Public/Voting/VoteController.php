<?php

namespace App\Http\Controllers\Public\Voting;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Vote;
use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class VoteController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('voting/Vote');
    }

    public function store(Request $request): void
    {

        // dd($request->all());
        $validated = $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'votes' => 'required|array',
        ]);

        foreach ($validated['votes'] as $vote) {
            if (Game::where('bgg_id', $vote['id'])->exists()) {
                $game = Game::where('bgg_id', $vote['id'])->first();
                $game->votes += 1;
                $game->score += $vote['points'];
                $game->save();
                Vote::create([
                    'game_id' => $game->id,
                    'points' => $vote['points'],
                    'user_name' => $validated['username'],
                    'email' => $validated['email'],
                    'voted_at' => now(),
                ]);
            } else {
                $game = Game::create([
                    'bgg_id' => $vote['id'],
                    'name' => $vote['name'],
                    'hyperlink' => 'https://boardgamegeek.com/boardgame/' . $vote['id'],
                    'score' => $vote['points'],
                    'image' => $vote['image'],
                    'votes' => 1,
                ]);
                Vote::create([
                    'game_id' => $game->id,
                    'points' => $vote['points'],
                    'user_name' => $validated['username'],
                    'email' => $validated['email'],
                    'voted_at' => now(),
                ]);
            }
        }
    }
}
