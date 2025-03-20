<?php

namespace App\Http\Controllers\Public\Voting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class SearchGameController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('search', ''));
        $index = (int) $request->input('index', 0);

        if (strlen($query) < 3) {
            return response()->json(['error' => 'Query must be at least 3 characters'], 400);
        }

        $games = $this->fetchSearchResults($query);
        $games = $this->fetchGameDetails($games);

        // return $games;

        return response()->json(['games' => [$index => array_values($games)]]);
    }

    private function fetchSearchResults(string $query): array
    {
        return Cache::remember("search_results_{$query}", 3600, function () use ($query) {
            $response = Http::get("https://boardgamegeek.com/xmlapi2/search?query={$query}&type=boardgame");
            if ($response->failed()) return [];

            $xml = simplexml_load_string($response->body());
            $array = json_decode(json_encode($xml), true);

            if (!isset($array['item'])) {
                return [];
            }

            $games = [];
            foreach ($array['item'] as $item) {
                if (!isset($item['@attributes']['id'], $item['name']['@attributes']['value'])) continue;
                $games[$item['@attributes']['id']] = [
                    'id' => $item['@attributes']['id'],
                    'name' => $item['name']['@attributes']['value'],
                    'year' => $item['yearpublished']['@attributes']['value'] ?? 'Unknown',
                ];
            }
            return $games;
        });
    }

    private function fetchGameDetails(array $games): array
    {
        $gameIds = implode(',', array_keys($games));
        $response = Http::get("https://boardgamegeek.com/xmlapi2/thing?id={$gameIds}");
        if ($response->failed()) return $games;

        $xml = simplexml_load_string($response->body());
        $array = json_decode(json_encode($xml), true); // Konwersja XML → JSON → Tablica

        if (!isset($array['item'])) {
            return $games;
        }

        foreach ($array['item'] as $item) {
            if (!isset($item['@attributes']['id'])) continue;
            $id = $item['@attributes']['id'];
            $games[$id]['image'] = $item['image'] ?? '';
        }

        return $games;
    }
}
