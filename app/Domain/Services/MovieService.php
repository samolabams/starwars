<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Services\HttpClient\HttpClient;
use App\Domain\Entity\Movie;
use App\Domain\Repository\CommentRepository;

class MovieService extends AbstractService
{
    /**
     *  Instance of httpClient
     *  @var HttpClient
     */
    private $httpClient;

    /**
     *  Instance of comment repository
     *  @var CommentRepository
     */
    private $commentRepository;

    public function __construct(HttpClient $httpClient, CommentRepository $commentRepository)
    {
        $this->httpClient = $httpClient;
        $this->commentRepository = $commentRepository;
    }

     /**
     * Get a movie from Stars Wars by id
     * @param int $id
     * @param bool $withComments
     * @return Movie
     */
    public function getOne($id, $withComments = true): Movie
    {
        $id = intval($id);
        $movieResponse = $this->httpClient->get('films/'.$id);
        $movieResponseAsJson = json_decode($movieResponse->getBodyAsString());

        $movieData = [
            'id' => $id,
            'title' => $movieResponseAsJson->title,
            'openingCrawl' => $movieResponseAsJson->opening_crawl,
            'charactersLinks' => $movieResponseAsJson->characters,
        ];

        if ($withComments) {
            $movieData['numberOfComments'] = $this->commentRepository->getCountByMovieId($id);
        }

        $movie = new Movie($movieData);

        return $movie;
    }

     /**
     * Get all movies from StarWars API
     * @return array
     */
    public function getAll(): array
    {
        $movies = [];
        $moviesResponse = $this->httpClient->get('films');
        $movieList = json_decode($moviesResponse->getBodyAsString())->results;
        $this->sortByReleaseDate($movieList);

        foreach ($movieList as $list) {
            $movieId = $this->extractIdFromUrl($list->url);

            $movie = new Movie([
                'id' => $movieId,
                'title' => $list->title,
                'openingCrawl' => $list->opening_crawl,
                'numberOfComments' => $this->commentRepository->getCountByMovieId($movieId),
            ]);

            array_push($movies, $movie);
        }

        return $movies;
    }

     /**
     * Sort movielist by release date
     * @param array $movieList
     * @return void
     */
    private function sortByReleaseDate(array &$movieList): void
    {
        usort($movieList, function($movieA, $movieB) {
            return $movieA->release_date <=> $movieB->release_date;
        });
    }

}
