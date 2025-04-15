<?php

namespace App\Services\Public\Ranking;

use App\DTOs\GameDTO;
use Illuminate\Support\Facades\Http;

class SearchGameService
{
    public function searchGames(string $query): array
    {
        $searchXml = $this->loadXml("https://boardgamegeek.com/xmlapi2/search?query={$query}&type=boardgame");

        if (!$searchXml || !isset($searchXml->item)) {
            return [];
        }

        $idNameMap = [];
        foreach ($searchXml->item as $item) {
            $id = (int) $item['id'];
            $name = (string) $item->name['value'];
            $idNameMap[$id] = $name;
        }

        $games = [];
        foreach (array_chunk(array_keys($idNameMap), 20) as $chunk) {
            $xml = $this->loadXml("https://boardgamegeek.com/xmlapi2/thing?id=" . implode(',', $chunk) . "&type=boardgame");

            if (!$xml || !isset($xml->item)) {
                continue;
            }

            foreach ($xml->item as $item) {
                $id = (int) $item['id'];
                $games[] = new GameDTO(
                    id: $id,
                    name: $idNameMap[$id] ?? 'Unknown',
                    year: isset($item->yearpublished['value']) ? (string) $item->yearpublished['value'] : 'Unknown',
                    image: isset($item->image) ? (string) $item->image : null
                );
            }
        }

        return $games;
    }

    private function loadXml(string $url): ?\SimpleXMLElement
    {
        $response = Http::get($url);

        if ($response->failed()) {
            return null;
        }

        $xml = simplexml_load_string($response->body()) ?: null;

        return $xml;
    }
}
