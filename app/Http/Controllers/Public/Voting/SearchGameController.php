<?php

namespace App\Http\Controllers\Public\Voting;

use App\Http\Controllers\Controller;
use App\Services\Public\Games\SearchGameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchGameController extends Controller
{

    public function __construct(
        protected SearchGameService $searchService,
    ) {}

    public function search(Request $request)
    {
        $query = trim($request->input('search', ''));
        $index = (int) $request->input('index', 0);

        if (strlen($query) < 3) {
            return response()->json(['error' => 'Query must be at least 3 characters'], 400);
        };

        $games = $this->searchService->searchGames($query);

        return response()->json(['games' => [$index => array_values($games)]]);
    }
}
