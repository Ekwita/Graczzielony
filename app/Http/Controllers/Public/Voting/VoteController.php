<?php

namespace App\Http\Controllers\Public\Voting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoteRequest;
use App\Models\Game;
use App\Models\Vote;
use Inertia\Inertia;
use Inertia\Response;

class VoteController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('ranking/Vote');
    }

    public function store(StoreVoteRequest $request): void
    {
        $validated = $request->validated();

        foreach ($validated['votes'] as $vote) {
            $game = Game::where('bgg_id', $vote['id'])->first();
            if (is_null($game)) {
                $game = $this->createGame($vote);
                $this->createVote($game, $vote, $validated);
            } else {
                $this->updateGame($game, $vote);
                $this->createVote($game, $vote, $validated);
            }
        }
    }

    private function updateGame(Game $game, array $vote)
    {
        $game->votes += 1;
        $game->score += $vote['points'];
        $game->save();
    }

    private function createGame(array $vote): Game
    {
        $game = Game::create([
            'bgg_id' => $vote['id'],
            'name' => $vote['name'],
            'hyperlink' => 'https://boardgamegeek.com/boardgame/' . $vote['id'],
            'score' => $vote['points'],
            'image' => $vote['image'],
            'votes' => 1,
        ]);

        return $game;
    }

    private function createVote(Game $game, array $vote, array $validated): void
    {
        Vote::create([
            'game_id' => $game->id,
            'points' => $vote['points'],
            'user_name' => $validated['username'],
            'email' => 'user@user.com',
            'voted_at' => now(),
        ]);
    }
}
