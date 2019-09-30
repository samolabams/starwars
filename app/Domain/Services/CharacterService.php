<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Services\HttpClient\HttpClient;
use App\Domain\Entity\Character;
use App\Domain\Services\EntityFilter;
use App\Domain\Services\EntitySorter;

class CharacterService extends AbstractService
{
    /**
     *  Instance of httpClient
     *  @var HttpClient
     */
    private $httpClient;

    /**
     *  Instance of movie service
     *  @var MovieService
     */
    private $movieService;

    public function __construct(HttpClient $httpClient, MovieService $movieService)
    {
        $this->httpClient = $httpClient;
        $this->movieService = $movieService;
    }

    /**
     * Get Character from StarsWars API by id
     * @param int $movieId
     * @param int $characterId
     * @return Character
     */
    public function getOne($movieId, $characterId)
    {
        $movie = $this->movieService->getOne($movieId);
        $characterResponse = $this->httpClient->get('people/'.$characterId);
        $characterResponseAsJson = json_decode($characterResponse->getBodyAsString());

        $character = new Character([
            'movie' => $movie,
            'id' => $characterId,
            'name' => $characterResponseAsJson->name,
            'height' => $characterResponseAsJson->height,
            'gender' => $characterResponseAsJson->gender,
        ]);

        return $character;
    }

    /**
     * Get all Characters belonging to a movie from StarsWars API
     * @param int $movieId
     * @param array $params
     * @return array
     */
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

            $character = new Character([
                'movie' => $movie,
                'id' => $characterId,
                'name' => $list->name,
                'height' => $list->height,
                'gender' => $list->gender,
            ]);

            array_push($characters, $character);
        }

        $characters = $this->processCharacterEntities($characters, $params);

        return $characters;
    }

    /**
     * Process character entities by passing them to a sorter and filter class based on the parameters
     * @param array $characters
     * @param array $params
     * @return array
     */
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

    /**
     * Get total height of characters in centimeter
     * @param array $entities
     * @return int
     */
    public function getTotalHeightInCentimeter(array $entities): int
    {
        return array_reduce($entities, function($sum, $entity) {
            return $sum + (int) $entity->height;
        }, 0);
    }

    /**
     * Convert height from centimeters to feet/in
     * @param int $height
     * @return string
     */
    public function convertFromCentimeterToFeetPerInches(int $value): string
    {
        $feetValue = intval($value / 30.48);
        $remainingValue = $value - (30.48 * $feetValue);
        $inchesValue = round($remainingValue * (1 / 2.54), 2);

        return $feetValue . 'ft' . ' ' . $inchesValue . 'in';
    }

}
