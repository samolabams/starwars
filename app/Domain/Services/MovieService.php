<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Services\HttpClient\HttpClient;
use App\Domain\Entity\Movie;
use App\Domain\Repository\CommentRepository;

class MovieService extends AbstractService
{
    private $httpClient;
    private $commentRepository;

    public function __construct(HttpClient $httpClient, CommentRepository $commentRepository)
    {
        $this->httpClient = $httpClient;
        $this->commentRepository = $commentRepository;
    }

    public function getOne($id, $withComments = true): Movie
    {
        $id = intval($id);
        $movieResponse = $this->httpClient->get('films/'.$id);
        $movieResponseAsJson = json_decode($movieResponse->getBodyAsString());

        $movie = new Movie;
        $movie->setId($id);
        $movie->setTitle($movieResponseAsJson->title);
        $movie->setOpeningCrawl($movieResponseAsJson->opening_crawl);
        $movie->setCharactersLinks($movieResponseAsJson->characters);
        if ($withComments) {
            $movie->setNumberOfComments($this->commentRepository->getCountByMovieId($id));
        }

        return $movie;
    }

    public function getAll(): array
    {
        $movies = [];
        $moviesResponse = $this->httpClient->get('films');
        $movieList = json_decode($moviesResponse->getBodyAsString())->results;
        $this->sortByReleaseDate($movieList);

        foreach ($movieList as $list) {
            $movieId = $this->extractIdFromUrl($list->url);

            $movie = new Movie;
            $movie->setId($movieId);
            $movie->setTitle($list->title);
            $movie->setOpeningCrawl($list->opening_crawl);
            $movie->setNumberOfComments($this->commentRepository->getCountByMovieId($movieId));

            array_push($movies, $movie);
        }

        return $movies;
    }

    private function sortByReleaseDate(array &$movieList): void
    {
        usort($movieList, function($movieA, $movieB) {
            return $movieA->release_date <=> $movieB->release_date;
        });
    }

}
