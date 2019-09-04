<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Services\HttpClient\HttpClient;
use App\Domain\Entity\Character;
use App\Domain\Services\EntityFilter;
use App\Domain\Services\EntitySorter;

class CharacterService extends AbstractService
{
    private $httpClient;
    private $movieService;

    public function __construct(HttpClient $httpClient, MovieService $movieService)
    {
        $this->httpClient = $httpClient;
        $this->movieService = $movieService;
    }

    public function getOne($movieId, $characterId)
    {
        $movie = $this->movieService->getOne($movieId);
        $characterResponse = $this->httpClient->get('people/'.$characterId);
        $characterResponseAsJson = json_decode($characterResponse->getBodyAsString());

        $character = new Character;
        $character->setMovie($movie);
        $character->setId(intval($characterId));
        $character->setName($characterResponseAsJson->name);
        $character->setHeight(intval($characterResponseAsJson->height));
        $character->setGender($characterResponseAsJson->gender);

        return $character;
    }

    public function getAll(int $movieId, array $params = []): array
    {
        $charactersList = [];
        $characters = [];
        $movie = $this->movieService->getOne($movieId);
        $results = $this->httpClient->getAsync($movie->charactersLinks);

        foreach($results->getBodyAsArray() as $result) {
            $charactersList[] = json_decode(
                $result['value']->getBody()->getContents()
            );
        }

        foreach ($charactersList as $list) {
            $characterId = $this->extractIdFromUrl($list->url);

            $character = new Character;
            $character->setMovie($movie);
            $character->setId($characterId);
            $character->setName($list->name);
            $character->setHeight(intval($list->height));
            $character->setGender($list->gender);

            array_push($characters, $character);
        }

        $characters = $this->processCharacterEntities($characters, $params);

        return $characters;
    }

    private function processCharacterEntities(array $characters, array $params): array
    {
        if (array_key_exists('filter', $params)) {
            $characters = (new EntityFilter)->filter($characters, 'gender', $params['filter']);
        }

        if (array_key_exists('sort', $params)) {
            $characters = (new EntitySorter)->sort($characters, $params['sort']);
        }

        return $characters;
    }

    public function getTotalHeightInCentimeter(array $entities): int
    {
        return array_reduce($entities, function($sum, $entity) {
            return $sum + (int) $entity->height;
        }, 0);
    }

    public function convertFromCentimeterToFeetPerInches(int $value): string
    {
        $feetValue = intval($value / 30.48);
        $remainingValue = $value - (30.48 * $feetValue);
        $inchesValue = round($remainingValue * (1 / 2.54), 2);

        return $feetValue . 'ft' . ' ' . $inchesValue . 'in';
    }

}
