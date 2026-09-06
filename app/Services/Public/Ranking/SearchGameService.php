<?php

namespace App\Services\Public\Ranking;

use App\DTOs\GameDTO;
use Illuminate\Support\Facades\Http;
use Ekwita\BggPhpApiClient\HttpClient\HttpClient as BggApiClient;

class SearchGameService
{

    public function __construct()
    {
        $this->client = new BggApiClient(env('BGG_API_KEY'));
    }

    public function searchGames(string $query): array
    {
        $simpleXml = $this->client->search()->boardgame($query);
        $foundGames = $simpleXml->item;

        if (count($foundGames) === 0) {
            return [];
        }

        $idNameMap = [];
        foreach ($foundGames as $item) {
            $id = (int) $item['id'];
            $name = (string) $item->name['value'];
            $idNameMap[$id] = $name;
        }

        $games = [];
        foreach (array_chunk(array_keys($idNameMap), 20) as $chunk) {
            $xmlItem = $this->client->thing()->findById($chunk)->item;

            if (!$xmlItem) {
                continue;
            }

            foreach ($xmlItem as $item) {
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
}
