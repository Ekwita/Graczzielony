<?php

namespace App\Http\Controllers\Public\Voting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoteRequest;
use App\Services\Public\Ranking\VoteService;
use Inertia\Inertia;
use Inertia\Response;

class VoteController extends Controller
{

    public function __construct(
        protected VoteService $voteService,
    ) {}

    public function index(): Response
    {
        return Inertia::render('ranking/Vote');
    }

    public function store(StoreVoteRequest $request): void
    {
        $validated = $request->validated();

        $this->voteService->storeVote($validated);
    }
}
