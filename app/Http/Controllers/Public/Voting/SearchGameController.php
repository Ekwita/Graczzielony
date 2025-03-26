<?php

namespace App\Http\Controllers\Public\Voting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        return response()->json(['games' => [$index => array_values($games)]]);
    }

    private function fetchSearchResults(string $query)
    {
        $response = Http::get("https://boardgamegeek.com/xmlapi2/search?query={$query}&type=boardgame");

        if ($response->failed()) {
            return [];
        }

        $xml = simplexml_load_string($response->body());
        if (!$xml || !isset($xml->item)) {
            return [];
        }

        $gameIds = [];
        foreach ($xml->item as $item) {
            $gameIds[] = (int) $item['id'];
        }

        if (empty($gameIds)) {
            return [];
        }

        $games = [];

        $chunks = array_chunk($gameIds, 20);

        foreach ($chunks as $chunk) {
            $idList = implode(',', $chunk);

            $gameResponse = Http::get("https://boardgamegeek.com/xmlapi2/thing?id={$idList}&type=boardgame");

            if ($gameResponse->failed()) {
                continue;
            }

            $gameXml = simplexml_load_string($gameResponse->body());
            if (!$gameXml || !isset($gameXml->item)) {
                continue;
            }

            foreach ($gameXml->item as $item) {
                if (!isset($item->name['value'])) {
                    continue;
                }

                $gameId = (int) $item['id'];
                $gameName = (string) $item->name['value'];
                $yearOfPublished = isset($item->yearpublished['value']) ? (string) $item->yearpublished['value'] : 'Unknown';
                $gameImage = isset($item->image) ? (string) $item->image : null;

                $games[] = [
                    'id' => $gameId,
                    'name' => $gameName,
                    'year' => $yearOfPublished,
                    'image' => $gameImage,
                ];
            }
        }

        return $games;
    }
}
